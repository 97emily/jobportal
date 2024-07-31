<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\PracticalTestMail;
use App\Models\Category;
use App\Models\JobListing;
use App\Models\PracticalQuestion;
use App\Models\PracticalTest;
use Barryvdh\DomPDF\Facade\Pdf;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class PracticalTestController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $tests = PracticalTest::latest()->paginate(config('constants.posts_per_page'));
        return view('admin.practical_tests.index', compact('tests', 'categories'))
            ->with('i', (request()->input('page', 1) - 1) * config('constants.posts_per_page'));
    }



    public function create()
    {
        $categories = Category::all();
        return view('admin.practical_tests.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'instructions' => 'required|string',
            'deadline' => 'required|date',
            'category_id' => 'required|exists:categories,id',
        ]);

        PracticalTest::create($request->all());

        return redirect()->route('practical_tests.index');
    }

    public function show(PracticalTest $practicalTest)
    {
        $questions = PracticalQuestion::all();
        return view('admin.practical_tests.show', compact('practicalTest', 'questions'));
    }

    public function edit(PracticalTest $practicalTest)
    {
        $categories = Category::all();
        return view('admin.practical_tests.edit', compact('practicalTest', 'categories'));
    }

    public function update(Request $request, PracticalTest $practicalTest)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'instructions' => 'required|string',
            'deadline' => 'required|date',
            'category_id' => 'required|exists:categories,id',
        ]);

        $practicalTest->update($request->all());

        return redirect()->route('practical_tests.index');
    }

    public function destroy(PracticalTest $practicalTest)
    {
        $practicalTest->delete();

        return redirect()->route('practical_tests.index');
    }



    public function sendPracticalTest(Request $request, $jobId)
    {
        Log::info('Request Data Before Validation', ['data' => $request->all()]);

        // Validate request
        try {
            $validatedData = $request->validate([
                'practical_tests_id' => 'required|exists:practical_tests,id',
                'selected_applicants' => 'nullable|string',
            ]);
            Log::info('Validation Successful', ['validatedData' => $validatedData]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation Failed', ['errors' => $e->errors()]);
            return back()->with('error', 'Validation failed. Please check your inputs.');
        }

        Log::info('Practical Test ID', ['id' => $request->practical_tests_id]);

        // Fetch practical test
        $practicalTest = PracticalTest::findOrFail($request->practical_tests_id);
        Log::info('Extracted Practical Test', ['practicalTest' => $practicalTest]);

        // Fetch practical questions associated with the test
        $practicalQuestions = $practicalTest->questions;

        // Generate PDF
        $pdf = PDF::loadView('pdf.practical_test', compact('practicalTest', 'practicalQuestions'));
        Log::info('PDF Generated', ['pdf_size' => strlen($pdf->output())]);

        // Determine applicants to send the practical test
        $selectedApplicants = explode(',', $request->input('selected_applicants'));

        if (empty($selectedApplicants) || (count($selectedApplicants) === 1 && $selectedApplicants[0] === "")) {
            // Fetch all applicants from the API endpoint
            $url = env('API_ENDPOINT_BASE_URL') . '/user/applicants-by-job';
            $response = Http::get($url, ['job_id' => $jobId]);

            if ($response->successful()) {
                $responseData = $response->json();

                if (isset($responseData['data']) && is_array($responseData['data'])) {
                    $applicants = $responseData['data'];

                    // Extract user_ids from the applicants array
                    $selectedApplicants = array_map(function ($applicant) {
                        return $applicant['applicant']['user_id'];
                    }, $applicants);

                    Log::info('Extracted user_ids from applicants', ['user_ids' => $selectedApplicants]);
                } else {
                    Log::error('No applicants found in the response data.');
                    return back()->with('error', 'No applicants found.');
                }
            } else {
                Log::error('Failed to fetch applicants from the API.', ['status' => $response->status()]);
                return back()->with('error', 'Failed to fetch applicants.');
            }
        }

        // Send email to each selected applicant
        foreach ($selectedApplicants as $user_id) {
            // Fetch applicant data from API
            $url = env('API_ENDPOINT_BASE_URL') . '/applicants/' . $user_id;
            $response = Http::get($url);

            if ($response->successful()) {
                $applicantData = $response->json()['data'];
                Log::info('Fetched applicant data', ['applicantData' => $applicantData]);

                if (isset($applicantData['email'])) {
                    $applicantEmail = $applicantData['email'];
                    $applicantName = $applicantData['name'];
                    $practicalTestTitle = $practicalTest->title;

                    try {
                        Mail::send('emails.practical_tests', compact('applicantName', 'practicalTestTitle'), function ($message) use ($applicantEmail, $pdf, $practicalTest) {
                            $message->to($applicantEmail)
                                    ->subject('Eclectics Practical Test: ' . $practicalTest->title)
                                    ->attachData($pdf->output(), 'PracticalTest.pdf');
                        });
                        Log::info('Email sent to applicant', ['email' => $applicantEmail]);
                    } catch (\Exception $e) {
                        Log::error('Failed to send practical test email.', ['email' => $applicantEmail, 'error' => $e->getMessage()]);
                    }
                } else {
                    Log::error('Applicant email not found.', ['user_id' => $user_id]);
                }
            } else {
                Log::error('Failed to fetch applicant details from the API.', ['user_id' => $user_id, 'status' => $response->status()]);
            }
        }

        return back()->with('success', 'Practical test sent to selected applicants.');
    }



    public function previewPracticalTest($jobId, Request $request)
{
    // Validate request
    $request->validate([
        'practical_tests_id' => 'required|exists:practical_tests,id',
    ]);

    // Fetch practical test
    $practicalTest = PracticalTest::findOrFail($request->practical_tests_id);

    // Fetch practical questions associated with the test
    $practicalQuestions = $practicalTest->questions;

    // Generate PDF
    $pdf = PDF::loadView('pdf.practical_test', compact('practicalTest', 'practicalQuestions'));

    // Return the PDF for preview
    return $pdf->stream('practical_test.pdf');
}

}

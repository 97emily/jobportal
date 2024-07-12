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
        // Validate request
        $request->validate([
            'practical_tests_id' => 'required|exists:practical_tests,id',
        ]);

        // Fetch practical test
        $practicalTest = PracticalTest::findOrFail($request->practical_tests_id);

        // Fetch practical questions associated with the test
        $practicalQuestions = $practicalTest->questions;

        // dd($practicalQuestions);

        // Generate PDF
        $pdf = PDF::loadView('pdf.practical_test', compact('practicalTest', 'practicalQuestions'));

        // Render PDF to browser
        // return $pdf->stream('PracticalTest.pdf');

        // Fetch shortlisted applicants from API
        $url = env('API_ENDPOINT_BASE_URL') . '/user/applicants-by-job';
        $response = Http::get($url, ['job_id' => $jobId]);

        if ($response->successful()) {
            $responseData = $response->json();

            if (isset($responseData['data']) && is_array($responseData['data'])) {
                $applicants = $responseData['data'];

                // Send email to each applicant
                foreach ($applicants as $applicantData) {
                    if (isset($applicantData['applicant']['email'])) {
                        $applicantEmail = $applicantData['applicant']['email'];
                        $applicantName = $applicantData['applicant']['name'];
                        $practicalTestTitle = $practicalTest->title;

                        Mail::send('emails.practical_tests', compact('applicantName', 'practicalTestTitle'), function($message) use ($applicantEmail, $pdf, $practicalTest) {
                            $message->to($applicantEmail)
                                    ->subject('Eclectics Practical Test: ' . $practicalTest->title)
                                    ->attachData($pdf->output(), 'PracticalTest.pdf');
                        });
                    }
                }

                return back()->with('success', 'Practical test sent to shortlisted applicants.');
            } else {
                return back()->with('error', 'No applicants found.');
            }
        } else {
            return back()->with('error', 'Failed to fetch shortlisted applicants.');
        }
    }
}

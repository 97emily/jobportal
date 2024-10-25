<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Interview;
use App\Mail\RejectionEmail;
use App\Models\JobListing;
use App\Models\PracticalTest;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class ApplicantsController extends Controller
{
    public function index()
    {
        // Fetch jobs or other necessary data
        $jobs = JobListing::all(); // Adjust this as per your data fetching logic

        return view('admin.applicants.index', compact('jobs'));
    }

    public function Allapplicants($job_id): View
    {
        $url = env('API_ENDPOINT_BASE_URL') . '/user/specific-job-applicants';
        $data = ['job_id' => $job_id];
        $response = Http::get($url, $data);

        // Fetch the job and its related category
        $job = JobListing::with(['category', 'tag', 'location', 'salaryRange', 'assessment'])->find($job_id);

        if (!$job) {
            return back()->with('error', 'Job listing not found.');
        }

        // Decode the response and get the applicants
        $shorListedApplicants = json_decode($response->body(), true);
        $shorListedApplicants = $shorListedApplicants['data'] ?? [];

        // Fetch only the practical tests related to the job's category
        $practicalTests = PracticalTest::where('category_id', $job->category_id)
            ->orderBy('title', 'asc')
            ->get();

        // Compute the total allocated marks and pass mark
        $totalAllocatedMarks = $job->assessment->questions->sum('allocated_marks');
        $computedPassMarkInMarks = $totalAllocatedMarks ? ($job->assessment->pass_mark / 100) * $totalAllocatedMarks : 0;

        // Update applicant status based on score
        foreach ($shorListedApplicants as &$applicant) {
            $score = $applicant['applicant']['assessment_score'];
            $applicant['applicant']['state'] = $score >= $computedPassMarkInMarks ? 'Shortlisted' : 'Not Shortlisted';
        }

        // Log job data for debugging
        // Log::info("Job data", ['job' => $job]);

        return view('admin.applicants.all-applicants', compact('shorListedApplicants', 'job', 'practicalTests'));
    }

    public function shortlistedapplicants($job_id): View
    {
        $url = env('API_ENDPOINT_BASE_URL') . '/user/applicants-by-job';
        $data = ['job_id' => $job_id];
        $response = Http::get($url, $data);

        // Fetch the job and its related category
        $job = JobListing::with(['category', 'tag', 'location', 'salaryRange', 'assessment'])->find($job_id);

        if (!$job) {
            return back()->with('error', 'Job listing not found.');
        }

        // Decode the response and get the applicants
        $shorListedApplicants = json_decode($response->body(), true);
        $shorListedApplicants = $shorListedApplicants['data'] ?? [];

        // Fetch only the practical tests related to the job's category
        $practicalTests = PracticalTest::where('category_id', $job->category_id)
            ->orderBy('title', 'asc')
            ->get();

        // Ensure $practicalTests is defined
        if ($practicalTests->isEmpty()) {
            $practicalTests = collect();
        }
        // Compute the total allocated marks and pass mark
        $totalAllocatedMarks = $job->assessment->questions->sum('allocated_marks');
        $computedPassMarkInMarks = $totalAllocatedMarks ? ($job->assessment->pass_mark / 100) * $totalAllocatedMarks : 0;

        // Update applicant status based on score
        foreach ($shorListedApplicants as &$applicant) {
            $score = $applicant['applicant']['assessment_score'];
            $applicant['applicant']['state'] = $score >= $computedPassMarkInMarks ? 'Shortlisted' : 'Not Shortlisted';
        }

        // Log job data for debugging
        // Log::info("Job data", ['job' => $job]);

        return view('admin.applicants.shortlisted', compact('shorListedApplicants', 'job', 'practicalTests'));
    }

    public function ApplicantInterviews($job_id)
    {
        try {
            $job = JobListing::findOrFail($job_id);
            $interviews = Interview::where('job_listings_id', $job_id)->get();
            foreach ($interviews as $interview) {
                $applicant = $this->fetchApplicantDetails($interview->applicant_id, $interview->job_listings_id);
                if ($applicant) {
                    $interview->applicant_name = $applicant['name'];
                    $interview->assessment_score = $applicant['assessment_score'];
                    $interview->practical_score = $applicant['practical_score'];
                    $interview->interview_score = $applicant['interview_score'];
                    $interview->status = $applicant['status'];
                }
            }
            return view('admin.applicants.interviews', compact('interviews', 'job'));
        } catch (Exception $e) {
            \Log::error('Error fetching interviews for job: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while fetching interviews. Please try again later.');
        }
    }

    public function FinalShortlist($job_id)
    {
        try {
            $job = JobListing::findOrFail($job_id);
            $interviews = Interview::where('job_listings_id', $job_id)
                ->where('shortlisted', true)
                ->get();
            foreach ($interviews as $interview) {
                $applicant = $this->fetchApplicantDetails($interview->applicant_id, $interview->job_listings_id);
                if ($applicant) {
                    $interview->applicant_name = $applicant['name'];
                    $interview->assessment_score = $applicant['assessment_score'];
                    $interview->practical_score = $applicant['practical_score'];
                    $interview->interview_score = $applicant['interview_score'];
                    $interview->status = $applicant['status'];
                }
            }
            return view('admin.applicants.finalshortlist', compact('interviews', 'job'));
        } catch (Exception $e) {
            \Log::error('Error fetching shortlisted applicants for job: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while fetching shortlisted applicants. Please try again later.');
        }
    }

    /**
     * Helper function to fetch applicant details.
     *
     * @param int $applicant_id
     * @param int $job_listings_id
     * @return array|null
     */

    private function fetchApplicantDetails($applicant_id, $job_listings_id)
    {
        try {
            $url = env('API_ENDPOINT_BASE_URL') . '/user/specific-job-applicants';
            $data = ['job_id' => $job_listings_id];

            $response = Http::get($url, $data);

            if ($response->successful()) {
                $applicants = json_decode($response->body(), true)['data'];

                foreach ($applicants as $applicantData) {
                    if ($applicantData['applicant']['id'] == $applicant_id) {
                        return [
                            'name' => $applicantData['applicant']['name'],
                            'assessment_score' => $applicantData['applicant']['assessment_score'],
                            'practical_score' => $applicantData['applicant']['practical_score'],
                            'interview_score' => $applicantData['applicant']['interview_score'],
                            'status' => $applicantData['applicant']['status'],
                        ];
                    }
                }
            }

            return null; // Return null if applicant not found
        } catch (Exception $e) {
            \Log::error('Error fetching applicant details: ' . $e->getMessage());
            return null;
        }
    }

    public function notShortlistedApplicants($job_id): View
    {
        // Fetch the job and its related category
        $job = JobListing::with(['category', 'tag', 'location', 'salaryRange', 'assessment'])->find($job_id);
        if (!$job) {
            return back()->with('error', 'Job listing not found.');
        }

        // Fetch all applicants for the job
        $url = env('API_ENDPOINT_BASE_URL') . '/user/specific-job-applicants';
        $response = Http::get($url, ['job_id' => $job_id]);
        $applicants = json_decode($response->body(), true)['data'] ?? [];

        // Compute the total allocated marks and pass mark
        $totalAllocatedMarks = $job->assessment->questions->sum('allocated_marks');
        $computedPassMarkInMarks = $totalAllocatedMarks ? ($job->assessment->pass_mark / 100) * $totalAllocatedMarks : 0;

        // Filter out applicants who are not shortlisted based on their assessment scores
        $notShortlistedApplicants = array_filter($applicants, function ($applicant) use ($computedPassMarkInMarks) {
            $score = $applicant['applicant']['assessment_score'];
            return $score < $computedPassMarkInMarks;
        });

        return view('admin.applicants.not-shortlisted', compact('notShortlistedApplicants', 'job'));
    }

    public function shortlist(Request $request)
    {
        // Validate the request data
        $request->validate([
            'interview_id' => 'required|exists:interviews,id',
        ]);

        // Find the interview by ID
        $interview = Interview::find($request->input('interview_id'));

        // Update the applicant's shortlisting status
        $interview->shortlisted = !$interview->shortlisted; // Toggle shortlisting status
        $interview->save();

        // Return a response (redirect back with a success message or return JSON)
        return response()->json(['success' => true, 'message' => 'Applicant shortlisting status updated successfully']);
    }

    public function shortlistedapplicantdetails($user_id): View
    {
        $url = env('API_ENDPOINT_BASE_URL') . '/applicants/' . $user_id;

        $response = Http::get($url);
        $shortListedApplicantDetails = json_decode($response->body(), true);

        if (isset($shortListedApplicantDetails['data'])) {
            $shortListedApplicantDetails = $shortListedApplicantDetails['data'];
        } else {
            abort(404, 'Applicant details not found');
        }

        return view('admin.jobs.applicantdetails', compact('shortListedApplicantDetails'));
    }

    public function rejections($job_id): View
    {
        $job = JobListing::with(['category', 'tag', 'location', 'salaryRange', 'assessment'])->find($job_id);
        if (!$job) {
            return back()->with('error', 'Job listing not found.');
        }

        // Fetch all applicants for the job
        $url = env('API_ENDPOINT_BASE_URL') . '/user/specific-job-applicants';
        $response = Http::get($url, ['job_id' => $job_id]);
        $applicants = json_decode($response->body(), true)['data'] ?? [];

        // Compute the total allocated marks and pass mark
        $totalAllocatedMarks = $job->assessment->questions->sum('allocated_marks');
        $computedPassMarkInMarks = $totalAllocatedMarks ? ($job->assessment->pass_mark / 100) * $totalAllocatedMarks : 0;

        // Fetch final shortlisted applicants
        $finalShortlistedApplicants = Interview::where('job_listings_id', $job_id)
            ->where('shortlisted', true)
            ->pluck('applicant_id')
            ->toArray();

        // Filter out rejected applicants based on their absence in the final shortlist
        $rejectedApplicants = array_filter($applicants, function ($applicant) use ($finalShortlistedApplicants) {
            return !in_array($applicant['applicant']['id'], $finalShortlistedApplicants);
        });

        return view('admin.applicants.rejections', compact('rejectedApplicants', 'job'));
    }

    // Sending the rejection emails
    public function sendRejectionEmail(Request $request)
    {
        \Log::info('sendRejectionEmail called');

        // Validate the request data
        try {
            $request->validate([
                'applicant_emails' => 'required|array',
                'applicant_emails.*' => 'required|email',
            ]);
        } catch (\Exception $e) {
            \Log::error('Validation failed: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Validation error. Please check the provided emails.']);
        }

        $emails = $request->input('applicant_emails');
        \Log::info('Emails to send rejection:', ['emails' => $emails]);

        try {
            foreach ($emails as $email) {
                \Log::info('Sending rejection email to: ' . $email);
                Mail::to($email)->send(new RejectionEmail());
            }
            \Log::info('Rejection emails sent successfully');

            return response()->json(['success' => true, 'message' => 'Rejection emails sent successfully']);
        } catch (\Exception $e) {
            \Log::error('Error sending rejection emails: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'An error occurred while sending the emails. Please try again later.']);
        }
    }
}

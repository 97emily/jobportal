<?php
// app/Http/Controllers/Admin/InterviewController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Interview;
use App\Models\JobListing;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use Exception;
use Illuminate\Validation\ValidationException;

class InterviewController extends Controller
{
    public function schedule(Request $request)
    {
        try {
            \Log::info('Incoming request data:', $request->all());

            $validated = $request->validate([
                'interview_date' => 'required|date',
                'interview_time' => 'required|date_format:H:i',
                'job_listings_id' => 'required|exists:job_listings,id',
                'location_id' => 'required|exists:locations,id',
                'applicant_id' => 'required|integer', // Validate as an integer
                'title' => 'required|string|max:255',
                'requirements' => 'required|string',
            ]);

            // Check if an interview already exists for the same applicant and job listing

            // $existingInterview = Interview::where('job_listings_id', $validated['job_listings_id'])
            //     ->where('applicant_id', $validated['applicant_id'])
            //     ->first();

            // if ($existingInterview) {
            //     return response()->json(['success' => false, 'message' => 'An interview has already been scheduled for this applicant and job listing'], 400);
            // }

            // \Log::info('Incoming request data:', $existingInterview);
            // Fetch applicant details from API
            $url = env('API_ENDPOINT_BASE_URL') . '/user/applicants-by-job';

            $data = [
                'job_id' => $validated['job_listings_id'],
            ];

            $response = Http::get($url, $data);

            if ($response->successful()) {
                $applicants = json_decode($response->body(), true)['data'];

                // Find the specific applicant by ID
                $applicant = null;
                foreach ($applicants as $applicantData) {
                    if ($applicantData['applicant']['id'] == $validated['applicant_id']) {
                        $applicant = $applicantData['applicant'];
                        break;
                    }
                }

                if (!$applicant) {
                    return response()->json(['success' => false, 'message' => 'Applicant not found'], 404);
                }
                \Log::info('Incoming request data:', $applicant);

                // Create the interview record
                $interview = Interview::create($validated);

                // Send an email to the applicant
                Mail::to($applicant['email'])->send(new \App\Mail\InterviewScheduled($interview, $applicant));

                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => false, 'message' => 'Failed to fetch applicant details from API'], 500);
            }
        } catch (ValidationException $e) {
            // Handle validation errors
            return response()->json(['success' => false, 'errors' => $e->errors()], 422);
        } catch (Exception $e) {
            // Log the error message
            \Log::error('Error scheduling interview: ' . $e->getMessage());

            // Return a generic error response
            return response()->json(['success' => false, 'message' => 'An error occurred while scheduling the interview. Please try again later.'], 500);
        }
    }

    public function getFormDetails()
    {
        try {
            $jobListings = JobListing::all();
            $locations = Location::all();
            return response()->json(['jobListings' => $jobListings, 'locations' => $locations]);
        } catch (Exception $e) {
            // Log the error message
            \Log::error('Error fetching form details: ' . $e->getMessage());

            return response()->json(['success' => false, 'message' => 'An error occurred while fetching form details. Please try again later.'], 500);
        }
    }

    public function getInterviewByApplicantId(Request $request)
    {
        try {
            $applicant_id = $request->input('applicant_id');

            if (!$applicant_id) {
                return response()->json(['success' => false, 'message' => 'Applicant ID is required'], 400);
            }

            $interviews = Interview::where('applicant_id', $applicant_id)
                ->with(['job', 'location'])
                ->get();

            if ($interviews->isEmpty()) {
                return response()->json(['success' => false, 'message' => 'No interviews found for the given applicant_id'], 404);
            }

            // Transform the interview data to include the location name and job title
            $interviews = $interviews->map(function ($interview) {
                return [
                    'id' => $interview->id,
                    'requirements' => $interview->requirements,
                    'title' => $interview->title,
                    'interview_date' => $interview->interview_date,
                    'interview_time' => $interview->interview_time,
                    'job_title' => $interview->job->title,
                    'location_name' => $interview->location->name,
                    'created_at' => $interview->created_at,
                    'updated_at' => $interview->updated_at,
                ];
            });

            return response()->json(['success' => true, 'interviews' => $interviews], 200);
        } catch (Exception $e) {
            // Log the error message
            \Log::error('Error fetching interview data: ' . $e->getMessage());

            return response()->json(['success' => false, 'message' => 'An error occurred while fetching the interview data. Please try again later.'], 500);
        }
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */


    // public function index()
    // {
    //     try {
    //         $interviews = Interview::latest()->paginate(config('constants.posts_per_page'));

    //         // Fetch applicant details for each interview
    //         foreach ($interviews as $interview) {
    //             $applicant = $this->fetchApplicantDetails($interview->applicant_id, $interview->job_listings_id);
    //             if ($applicant) {
    //                 $interview->applicant_name = $applicant['name'];
    //                 $interview->assessment_score = $applicant['assessment_score'];
    //                 $interview->practical_score = $applicant['practical_score'];
    //                 $interview->interview_score = $applicant['interview_score'];
    //                 $interview->status = $applicant['status'];
    //                 // Add more fields as needed
    //             }
    //         }

    //         $locations = Location::all();
    //         return view('admin.interviews.index', compact('interviews', 'locations'))
    //             ->with('i', (request()->input('page', 1) - 1) * config('constants.posts_per_page'));
    //     } catch (Exception $e) {
    //         \Log::error('Error fetching interviews: ' . $e->getMessage());
    //         return redirect()->back()->with('error', 'An error occurred while fetching interviews. Please try again later.');
    //     }
    // }
  /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */

    public function show($id)
    {
        try {
            $interview = Interview::findOrFail($id);
            $applicant = $this->fetchApplicantDetails($interview->applicant_id, $interview->job_listings_id);
            if ($applicant) {
                $interview->applicant_name = $applicant['name'];
                $interview->assessment_score = $applicant['assessment_score'];
                $interview->practical_score = $applicant['practical_score'];
                $interview->interview_score = $applicant['interview_score'];
                $interview->status = $applicant['status'];
                // Add more fields as needed
            }
            return view('admin.interviews.show', compact('interview'));
        } catch (Exception $e) {
            \Log::error('Error fetching interview details: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while fetching interview details. Please try again later.');
        }
    }

    /**
     * Show the form for rescheduling the specified interview.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function reschedule($id)
    {
        $interview = Interview::findOrFail($id);
        $jobListings = JobListing::all();
        $locations = Location::all();
        return view('admin.interviews.reschedule', compact('interview', 'jobListings', 'locations'));
    }

    /**
     * Update the specified interview's schedule.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateSchedule(Request $request, $id)
    {
        try {
            \Log::info('Incoming request data for reschedule:', $request->all());

            $validated = $request->validate([
                'interview_date' => 'required|date',
                'interview_time' => 'required|date_format:H:i',
                'job_listings_id' => 'required|exists:job_listings,id',
                'location_id' => 'required|exists:locations,id',
                'title' => 'required|string|max:255',
                'requirements' => 'required|string',
            ]);

            $interview = Interview::findOrFail($id);
            $interview->update($validated);

            // Fetch applicant details from API
            $url = env('API_ENDPOINT_BASE_URL') . '/user/applicants-by-job';
            $data = ['job_id' => $validated['job_listings_id']];
            $response = Http::get($url, $data);

            if ($response->successful()) {
                $applicants = json_decode($response->body(), true)['data'];
                $applicant = null;
                foreach ($applicants as $applicantData) {
                    if ($applicantData['applicant']['id'] == $interview->applicant_id) {
                        $applicant = $applicantData['applicant'];
                        break;
                    }
                }

                if ($applicant) {
                    Mail::to($applicant['email'])->send(new \App\Mail\InterviewScheduled($interview, $applicant));
                }
            }

            return redirect()->route('admin.interviews.index')->with('success', 'Interview rescheduled successfully');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (Exception $e) {
            \Log::error('Error rescheduling interview: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while rescheduling the interview. Please try again later.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        try {
            $interview = Interview::findOrFail($id);
            $interview->delete();
            return redirect()->route('admin.interviews.index')->with('success', 'Interview deleted successfully');
        } catch (Exception $e) {
            \Log::error('Error deleting interview: ' . $e->getMessage());
            return redirect()->route('admin.interviews.index')->with('error', 'An error occurred while deleting the interview. Please try again later.');
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
            $url = env('API_ENDPOINT_BASE_URL') . '/user/applicants-by-job';
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

    public function index()
    {
        try {
            // Get all job listings
            $jobs = JobListing::all();

            // Get distinct job IDs from the interviews table
            $interviewJobIds = Interview::select('job_listings_id')
                                        ->distinct()
                                        ->pluck('job_listings_id')
                                        ->toArray();

            // Add the job IDs to the view
            return view('admin.interviews.index1', compact('jobs', 'interviewJobIds'));
        } catch (Exception $e) {
            \Log::error('Error fetching jobs: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while fetching jobs. Please try again later.');
        }
    }

    public function showJobInterviews($job_id)
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
            return view('admin.interviews.show1', compact('interviews', 'job'));
        } catch (Exception $e) {
            \Log::error('Error fetching interviews for job: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while fetching interviews. Please try again later.');
        }
    }

    public function showShortlistedApplicants($job_id)
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
        return view('admin.interviews.shortlisted', compact('interviews', 'job'));
    } catch (Exception $e) {
        \Log::error('Error fetching shortlisted applicants for job: ' . $e->getMessage());
        return redirect()->back()->with('error', 'An error occurred while fetching shortlisted applicants. Please try again later.');
    }
}



}

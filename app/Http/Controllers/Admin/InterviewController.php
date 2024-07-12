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

            \Log::info('Validated interview data:', $validated);
            // Fetch applicant details from API
            $url = env('API_ENDPOINT_BASE_URL') . '/user/applicants-by-job';

            $data = [
                'applicant_id' => $validated['applicant_id'],
            ];

            $response = Http::get($url, $data);

            if ($response->successful()) {
                $applicant = json_decode($response->body(), true)['data']['applicant'];

                // Create the interview record
                $interview = Interview::create($validated);


                // Send an email to the applicant
                Mail::to($applicant['email'])->send(new \App\Mail\InterviewScheduled($interview, $applicant));

                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => false, 'message' => 'Failed to fetch applicant details from API'], 500);
            }
               // Proceed with your existing logic...
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
}

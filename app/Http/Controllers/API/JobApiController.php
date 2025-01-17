<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\JobListing;
use App\Models\PracticalTest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Swagger API Documentation",
 *      description="L5 Swagger API description",
 * )
 *
 * @OA\PathItem(path="/api")
 *
 * @OA\Server(
 *      url="http://127.0.0.1:8000",
 *      description="API Server"
 * )
 *
 * @OA\SecurityScheme(
 *      securityScheme="bearerAuth",
 *      type="http",
 *      scheme="bearer"
 * )
 */

class JobApiController extends Controller
{

    /**
     * @OA\Get(
     *     path="/api/jobs",
     *     summary="Get list of job listings",
     *     tags={"Jobs"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/JobListing")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden"
     *     ),
     *     security={
     *         {"bearerAuth": {}}
     *     }
     * )
     */
// Endpoint to show all the open jobs
    public function index(): JsonResponse
    {
        $jobs = JobListing::with(['category', 'tag', 'location', 'salaryRange', 'assessment'])
            ->where('status', 'open')
            ->latest()
            ->paginate(config('constants.posts_per_page'));

        $response = $jobs->map(function ($job) {
            return [
                'id' => $job->id,
                'title' => $job->title,
                'description' => $job->job_description,
                'status' => $job->status,
                'closing_date' => $job->closing_date,
                'category_id' => $job->category_id,
                'category' => $job->category ? $job->category->name : 'Not specified',
                'tag' => $job->tag ? $job->tag->name : 'Not specified',
                'location' => $job->location ? $job->location->name : 'Not specified',
                'salary_range' => $job->salaryRange ? $job->salaryRange->minimum . '-' . $job->salaryRange->maximum : 'Not specified',
                'assessment_id' => $job->assessment ? $job->assessment->id : 'Not specified',
            ];
        });

        return response()->json($response);
    }


    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'job_description' => 'required|string',
            'status' => 'required|in:open,preview,closed',
            'closing_date' => 'required|date',
            'category_id' => 'required|exists:categories,id',
            'tag_id' => 'required|exists:tags,id',
            'location_id' => 'nullable|exists:locations,id',
            'salary_range_id' => 'nullable|exists:salary_ranges,id',
            'assessment_id' => 'nullable|exists:assessments,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $job = JobListing::create($request->all());

        return response()->json(['success' => true, 'message' => 'Job listing created successfully.', 'data' => $job], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/jobs/{id}",
     *     summary="Get job listing details",
     *     tags={"Jobs"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/JobListing")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Job not found"
     *     ),
     *     security={
     *         {"bearerAuth": {}}
     *     }
     * )
     */
    public function show(Request $request, $id): JsonResponse
    {
        $job = JobListing::with(['category', 'tag', 'location', 'salaryRange', 'assessment'])->find($id);

        if (!$job) {
            return response()->json(['error' => 'Job not found.'], 404);
        }

        $response = [
            'id' => $job->id,
            'title' => $job->title,
            'description' => $job->job_description,
            'status' => $job->status,
            'closing_date' => $job->closing_date,
            'category_id' => $job->category_id,
            'category' => $job->category ? $job->category->name : 'Not specified',
            'tag' => $job->tag ? $job->tag->name : 'Not specified',
            'location' => $job->location ? $job->location->name : 'Not specified',
            'salary_range' => $job->salaryRange ? $job->salaryRange->minimum . '-' . $job->salaryRange->maximum : 'Not specified',
            'assessment_id' => $job->assessment ? $job->assessment->id : 'Not specified',
        ];

        return response()->json($response);
    }

    public function update(Request $request, JobListing $job): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'job_description' => 'required|string',
            'status' => 'required|in:open,preview,closed',
            'closing_date' => 'required|date',
            'category_id' => 'required|exists:categories,id',
            'tag_id' => 'required|exists:tags,id',
            'location_id' => 'nullable|exists:locations,id',
            'salary_range_id' => 'nullable|exists:salary_ranges,id',
            'assessment_id' => 'nullable|exists:assessments,id',
            'tags' => 'array',
            'categories' => 'array',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $job->update($request->all());
        $job->tags()->sync($request->input('tags', []));

        return response()->json(['success' => true, 'message' => 'Job updated successfully', 'data' => $job]);
    }


    public function destroy(JobListing $job): JsonResponse
    {
        $job->delete();

        return response()->json(['success' => true, 'message' => 'Job deleted successfully.']);
    }


    public function shortlisted($job_id): View
    {
        $url = env('API_ENDPOINT_BASE_URL') . '/user/specific-job-applicants';
        $data = ['job_id' => $job_id];
        $response = Http::get($url, $data);

        $job = JobListing::with(['category', 'tag', 'location', 'salaryRange', 'assessment'])->find($job_id);

        if (!$job) {
            return back()->with('error', 'Job listing not found.');
        }

        $shorListedApplicants = json_decode($response->body(), true);
        $shorListedApplicants = $shorListedApplicants['data'] ?? [];

        $practicalTests = PracticalTest::where('category_id', $job->category_id)
                                       ->orderBy('title', 'asc')
                                       ->get();

        if ($practicalTests->isEmpty()) {
            $practicalTests = collect();
        }

        $totalAllocatedMarks = $job->assessment->questions->sum('allocated_marks');
        $computedPassMarkInMarks = $totalAllocatedMarks ? ($job->assessment->pass_mark / 100) * $totalAllocatedMarks : 0;

        foreach ($shorListedApplicants as &$applicant) {
            $score = $applicant['applicant']['assessment_score'];
            $applicant['applicant']['state'] = $score >= $computedPassMarkInMarks ? 'Shortlisted' : 'Not Shortlisted';
        }

        return view('admin.jobs.shortlisted', compact('shorListedApplicants', 'job', 'practicalTests'));
    }


    public function shortlistedapplicantdetails($user_id): View
    {
        $url = env('API_ENDPOINT_BASE_URL') . '/applicants/' . $user_id;
        $response = Http::get($url);
        $shortListedApplicantDetails = json_decode($response->body(), true);

        if (isset($shortListedApplicantDetails['data'])) {
            $shortListedApplicantDetails = $shortListedApplicantDetails['data'];

            $ngrokUrl = 'https://d675-102-219-208-126.ngrok-free.app/storage/';

            if (isset($shortListedApplicantDetails['highest_education_level']['certificate'])) {
                $shortListedApplicantDetails['highest_education_level']['certificate'] = $ngrokUrl . $shortListedApplicantDetails['highest_education_level']['certificate'];
            }

            if (isset($shortListedApplicantDetails['secondary_education']['kcseCertificate'])) {
                $shortListedApplicantDetails['secondary_education']['kcseCertificate'] = $ngrokUrl . $shortListedApplicantDetails['secondary_education']['kcseCertificate'];
            }

            if (isset($shortListedApplicantDetails['professional_qualifications'])) {
                foreach ($shortListedApplicantDetails['professional_qualifications'] as &$qualification) {
                    if (isset($qualification['professionalCertificate'])) {
                        $qualification['professionalCertificate'] = $ngrokUrl . $qualification['professionalCertificate'];
                    }
                }
            }
        } else {
            abort(404, 'Applicant details not found');
        }

        return view('admin.jobs.applicantdetails', compact('shortListedApplicantDetails'));
    }


    public function updateApplicant(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'assessment_score' => 'required|numeric',
            'practical_score' => 'required|numeric',
            'interview_score' => 'nullable|numeric',
            'status' => 'required|string',
        ]);

        \Log::info('Received data:', $request->all());

        $url = env('API_ENDPOINT_BASE_URL') . '/user/updateAssessmentAttempt';

        try {
            $response = Http::put($url, [
                'id' => $request->id,
                'assessment_score' => $request->assessment_score,
                'practical_score' => $request->practical_score,
                'interview_score' => $request->interview_score,
                'status' => ucfirst($request->status),
            ]);

            \Log::info('API response:', $response->json());

            return response()->json($response->json());
        } catch (\Exception $e) {
            \Log::error('Error updating applicant:', ['message' => $e->getMessage()]);

            return response()->json(['success' => false, 'message' => 'Failed to update applicant details.'], 500);
        }
    }
}

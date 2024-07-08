<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\JobListing;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class JobApiController extends Controller
{
    public function index(): JsonResponse
    {
        // return response()->json('hello world');
        $jobs = JobListing::with(['category', 'tag', 'location', 'salaryRange', 'assessment'])
            // ->where('status', 'open')
            ->latest()
            ->paginate(config('constants.posts_per_page'));
        $response = $jobs->map(function($job) {

// return [$job->location ? $job->location->name : $job];
            return [
                'id' => $job->id,
                'title' => $job->title,
                'description' => $job->job_description,
                'status' => $job->status,
                'closing_date' => $job->closing_date,
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
        $url = env('API_ENDPOINT_BASE_URL') . '/user/applicants-by-job';

        $data = [
            'job_id' => $job_id,
        ];

        $response = Http::get($url, $data);

        $shorListedApplicants = json_decode($response->body(), true);

        $shorListedApplicants = $shorListedApplicants['data'];

        return view('admin.jobs.shortlisted', compact('shorListedApplicants'));
    }

    public function shortlistedapplicantdetails($user_id): View
    {
        $url = env('API_ENDPOINT_BASE_URL') . '/applicants/'. $user_id;

        $response = Http::get($url);
        $shortListedApplicantDetails = json_decode($response->body(), true);

        if (isset($shortListedApplicantDetails['data'])) {
            $shortListedApplicantDetails = $shortListedApplicantDetails['data'];
        } else {
            abort(404, 'Applicant details not found');
        }

        return view('admin.jobs.applicantdetails', compact('shortListedApplicantDetails'));
    }

     public function updateApplicant(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'score' => 'required|integer',
            'status' => 'required|string',
        ]);

        $url = env('API_ENDPOINT_BASE_URL') . '/user/updateShortlistedApplicant'; // Replace with your API endpoint

        $response = Http::put($url, [
            'id' => $request->id,
            'score' => $request->score,
            'status' => ucfirst($request->status),
        ]);
        return response()->json($response->json());
    }

}

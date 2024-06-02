<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\JobListing;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JobApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:job-list|job-create|job-edit|job-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:job-create', ['only' => ['store']]);
        $this->middleware('permission:job-edit', ['only' => ['update']]);
        $this->middleware('permission:job-delete', ['only' => ['destroy']]);
    }

    public function index(): JsonResponse
    {
        $jobs = JobListing::latest()->paginate(config('constants.posts_per_page'));
        return response()->json($jobs);
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
            'location' => 'nullable|string|max:255',
            'salary_min' => 'nullable|numeric|min:0',
            'salary_max' => 'nullable|numeric|min:0',
            'assessment_test' => 'nullable|string|max:255',
            'threshold_score' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $job = JobListing::create($request->all());

        return response()->json(['success' => true, 'message' => 'Job listing created successfully.', 'data' => $job], 201);
    }

    public function show(JobListing $job): JsonResponse
    {
        return response()->json($job);
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
            'location' => 'nullable|string|max:255',
            'salary_min' => 'nullable|numeric|min:0',
            'salary_max' => 'nullable|numeric|min:0',
            'assessment_test' => 'nullable|string|max:255',
            'threshold_score' => 'nullable|integer|min:0',
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
}

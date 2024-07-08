<?php

 namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\JobListing;
use App\Models\Tag;
use App\Models\SalaryRange;
use App\Models\Assessment;
use App\Models\Location;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JobController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:job-list|job-create|job-edit|job-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:job-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:job-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:job-delete', ['only' => ['destroy']]);
    }

    public function index(): View
    {
        $jobs = JobListing::latest()->paginate(config('constants.posts_per_page'));

        $categories = Category::all();
        $tags = Tag::all();
        $locations = Location::all(); // Load all locations
        $salaryRanges = SalaryRange::all(); // Load all salary ranges
        $assessments = Assessment::all(); // Load all assessments
        return view('admin.jobs.index', compact('jobs', 'tags', 'locations', 'salaryRanges',))
            ->with('i', (request()->input('page', 1) - 1) * config('constants.posts_per_page'));
    }

    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        $locations = Location::all(); // Load all locations
        $salaryRanges = SalaryRange::all(); // Load all salary ranges
        $assessments = Assessment::all(); // Load all assessments

        return view('admin.jobs.create', compact('categories', 'tags', 'locations', 'salaryRanges', 'assessments'));
    }


    public function show(JobListing $job): View
    {
        $categories = Category::all();
        $tags = Tag::all();
        $locations = Location::all();
        $salaryRanges = SalaryRange::all();
        $assessments = Assessment::all();

        return view('admin.jobs.show', compact('job', 'categories', 'tags', 'locations', 'salaryRanges', 'assessments'));
    }

    public function edit(JobListing $job)
    {
        $categories = Category::all();
        $tags = Tag::all();
        $locations = Location::all(); // Load all locations
        $salaryRanges = SalaryRange::all(); // Load all salary ranges
        $assessments = Assessment::all(); // Load all assessments

        return view('admin.jobs.edit', compact('job', 'categories', 'tags', 'locations', 'salaryRanges', 'assessments'));
    }

    public function store(Request $request)
    {
        $request->validate([
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

        $job = JobListing::create($request->all());

        return redirect()->route('jobs.index')->with('success', 'Job listing created successfully.');
    }

    public function update(Request $request, JobListing $job)
    {
        $request->validate([
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

        $job->update($request->all());

        return redirect()->route('jobs.edit', $job->id)->with('success', 'Job updated successfully');
    }

    public function destroy(JobListing $job): JsonResponse
    {
        $job->delete();

        return response()->json(['success' => true, 'message' => __('Job deleted successfully.')]);
    }
}

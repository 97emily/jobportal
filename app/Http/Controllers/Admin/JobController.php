<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\JobListing;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('permission:job-list|job-create|job-edit|job-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:job-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:job-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:job-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {

        //  $response = \Illuminate\Support\Facades\Http::get('https://crm.ngcdf.go.ke/api/bootstrap?n=mobile-disbursements&constid=56');
        //  dd($response->body());

        //  $response = \Illuminate\Support\Facades\Http::get('https://0049-41-90-101-26.ngrok-free.app/api/jobs');
        //  dd($response->body());

        $jobs = JobListing::latest()->paginate(config('constants.posts_per_page'));

        return view('admin.jobs.index', compact('jobs'))
            ->with('i', (request()->input('page', 1) - 1) * config('constants.posts_per_page'));
    }

    // Ensure to use the necessary middleware for permissions if needed
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.jobs.create', compact('categories', 'tags'));
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
            'location' => 'nullable|string|max:255',
            'salary_min' => 'nullable|numeric|min:0',
            'salary_max' => 'nullable|numeric|min:0',
            'assessment_test' => 'nullable|string|max:255',
            'threshold_score' => 'nullable|integer|min:0',
        ]);

        JobListing::create($request->all());

        return redirect()->route('jobs.index')->with('success', 'Job listing created successfully.');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function show(JobListing $job): View
    {
        return view('admin.jobs.show', compact('job'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function edit(JobListing $job): View
    {
        // $tags = $this->getTags();
        // $categories = $this->getCategories();
        $categories = Category::all();
        $tags = Tag::all();

        return view('admin.jobs.edit', compact(['job', 'tags', 'categories']));
    }

    public function update(Request $request, JobListing $job): RedirectResponse
    {
        $request->validate([
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
            'tags' => 'array', // Assuming 'tags' and 'categories' are arrays in your form
            'categories' => 'array',
        ]);

        $job->update($request->all());
        $job->tags()->sync($request->input('tags', []));

        return redirect()->route('jobs.edit', $job->id)->with('success', __('Job updated successfully'));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function destroy(JobListing $job): JsonResponse
    {
        $job->delete();

        return response()->json(['success' => true, 'message' => __('Job deleted successfully.')]);
    }

    private function getTags()
    {
        return Tag::pluck('name', 'id');
    }

    private function getCategories()
    {
        return Category::pluck('name', 'id');
    }
}

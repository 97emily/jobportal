<?php
// app/Http/Controllers/InterviewController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Interview;
use App\Models\Job;
use App\Models\JobListing;
use App\Models\Location;
use Illuminate\Http\Request;

class InterviewController extends Controller
{
    public function index()
    {
        $jobs=JobListing::all();
        $locations=Location::all();
        $interviews = Interview::latest()->paginate(config('constants.posts_per_page'));
        return view('admin.interviews.index', compact('interviews', 'locations', 'jobs'))
        ->with('i', (request()->input('page', 1) - 1) * config('constants.posts_per_page'));
    }

    public function create()
    {
        $jobs = JobListing::all();
        $locations = Location::all();
        return view('admin.interviews.create', compact('jobs', 'locations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'interview_date' => 'required|date',
            'interview_time' => 'required|date_format:H:i',
            'job_listings_id' => 'required|exists:job_listings,id',
            //'practical_tests_id' => 'required|exists:practical_tests,id',
            'location_id' => 'required|exists:locations,id',
            'title' => 'required|string|max:255',
            'requirements' => 'required|string',
        ]);

        Interview::create($request->all());

        return redirect()->route('interviews.index')->with('success', 'Interview created successfully.');
    }

    public function show(Interview $interview)
    {
        return view('admin.interviews.show', compact('interview'));
    }

    public function edit(Interview $interview)
    {
        $jobs = JobListing::all();
        $locations = Location::all();
        return view('admin.interviews.edit', compact('interview', 'jobs', 'locations'));
    }

    public function update(Request $request, Interview $interview)
    {
        $request->validate([
            'interview_date' => 'required|date',
            'interview_time' => 'required|date_format:H:i',
            'job_listings_id' => 'required|integer',
            'location_id' => 'required|integer',
            'title' => 'required|string|max:255',
            'requirements' => 'required|string',
        ]);

        $interview->update($request->all());

        return redirect()->route('interviews.index')->with('success', 'Interview updated successfully.');
    }

    public function destroy(Interview $interview)
    {
        $interview->delete();

        return redirect()->route('interviews.index')->with('success', 'Interview deleted successfully.');
    }
}

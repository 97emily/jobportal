<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Assessment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AssessmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('permission:assessment-list|assessment-create|assessment-edit|assessment-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:assessment-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:assessment-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:assessment-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        $assessments = Assessment::latest()->paginate(config('constants.posts_per_page'));
        return view('admin.assessments.index', compact('assessments'))
            ->with('i', (request()->input('page', 1) - 1) * config('constants.posts_per_page'));
    }

    // Ensure to use the necessary middleware for permissions if needed
    public function create()
    {
        $categories = Category::all();
        return view('admin.assessments.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'pass_mark' => 'nullable|integer|min:0',
            'categories' => 'array',
        ]);

        Assessment::create($request->all());

        return redirect()->route('assessments.index')->with('success', 'Assessment listing created successfully.');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Assessment  $assessment
     * @return \Illuminate\Http\Response
     */
    public function show(Assessment $assessment): View
    {
        return view('admin.assessments.show', compact('assessment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Assessment  $assessment
     * @return \Illuminate\Http\Response
     */
    public function edit(Assessment $assessment): View
    {
        $categories = Category::all();
        return view('admin.assessments.edit', compact(['assessment', 'categories']));
    }

    public function update(Request $request, Assessment $assessment): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'pass_mark' => 'nullable|integer|min:0',
            'categories' => 'array',
        ]);

        $assessment->update($request->all());

        return redirect()->route('assessments.edit', $assessment->id)->with('success', __('Assessment updated successfully'));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Assessment  $assessment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Assessment $assessment): JsonResponse
    {
        $assessment->delete();

        return response()->json(['success' => true, 'message' => __('Assessment deleted successfully.')]);
    }
}

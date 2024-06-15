<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Models\Question;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class QuestionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:question-list|question-create|question-edit|question-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:question-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:question-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:question-delete', ['only' => ['destroy']]);
    }

    public function index(): View
    {
        $questions = Question::latest()->paginate(config('constants.posts_per_page'));

        return view('admin.questions.index', compact('questions'))
            ->with('i', (request()->input('page', 1) - 1) * config('constants.posts_per_page'));
    }

    public function create(): View
    {
        $assessments = Assessment::all();
        return view('admin.questions.create', compact('assessments'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'question' => 'required|string',
            'allocated_marks' => 'required|integer',
            'allocated_time' => 'required|integer',
            'multiple_choices' => 'required|array',
            'marking_scheme' => 'required|array',
            'assessment_id' => 'required|exists:assessments,id',
        ]);

        $data = $request->all();
        $data['multiple_choices'] = json_encode($request->multiple_choices);
        $data['marking_scheme'] = json_encode($request->marking_scheme);

        Question::create($data);

        return redirect()->route('questions.index')->with('success', 'Question created successfully.');
    }

    public function show(Question $question): View
    {
        return view('admin.questions.show', compact('question'));
    }

    public function edit(Question $question): View
    {
        $assessments = Assessment::all();
        return view('admin.questions.edit', compact('question', 'assessments'));
    }

    public function update(Request $request, Question $question): RedirectResponse
    {
        $request->validate([
            'question' => 'required|string',
            'allocated_marks' => 'required|integer',
            'allocated_time' => 'required|integer',
            'multiple_choices' => 'required|array',
            'marking_scheme' => 'required|array',
            'assessment_id' => 'required|exists:assessments,id',
        ]);

        $data = $request->all();
        $data['multiple_choices'] = json_encode($request->multiple_choices);
        $data['marking_scheme'] = json_encode($request->marking_scheme);

        $question->update($data);

        return redirect()->route('questions.index')->with('success', 'Question updated successfully.');
    }

    public function destroy(Question $question): JsonResponse
    {
        $question->delete();

        return response()->json(['success' => true, 'message' => 'Question deleted successfully.']);
    }

    private function getTags()
    {
        return Tag::pluck('name', 'id');
    }

    private function getAssessments()
    {
        return Category::pluck('name', 'id');
    }
}

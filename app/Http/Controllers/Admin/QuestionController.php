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
        $questions = Question::latest()->paginate(5);

        return view('admin.questions.index', compact('questions'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function create(): View
    {
        $assessments = Assessment::all();
        return view('admin.questions.create', compact('assessments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string',
            'allocated_marks' => 'required|integer',
            'allocated_time' => 'required|integer',
            'assessment_id' => 'required|exists:assessments,id',
            'multiple_choices' => 'required|array',
            'correct_answers' => 'required|array'
        ]);

        $multipleChoices = json_encode($request->input('multiple_choices'));
        $markingScheme = json_encode($request->input('correct_answers'));

        Question::create([
            'question' => $request->input('question'),
            'allocated_marks' => $request->input('allocated_marks'),
            'allocated_time' => $request->input('allocated_time'),
            'multiple_choices' => $multipleChoices,
            'marking_scheme' => $markingScheme,
            'assessment_id' => $request->input('assessment_id')
        ]);

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
            'assessment_id' => 'required|exists:assessments,id',
            'multiple_choices' => 'required|array',
            'correct_answers' => 'required|array'
        ]);

        $multipleChoices = json_encode($request->input('multiple_choices'));
        $markingScheme = json_encode($request->input('correct_answers'));

        $question->update([
            'question' => $request->input('question'),
            'allocated_marks' => $request->input('allocated_marks'),
            'allocated_time' => $request->input('allocated_time'),
            'multiple_choices' => $multipleChoices,
            'marking_scheme' => $markingScheme,
            'assessment_id' => $request->input('assessment_id')
        ]);

        return redirect()->route('questions.index')->with('success', 'Question updated successfully.');
    }


    public function destroy(Question $question): JsonResponse
    {
        $question->delete();

        return response()->json(['success' => true, 'message' => 'Question deleted successfully.']);
    }
}

<?php

// app/Http/Controllers/QuestionController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class QuestionController extends Controller

{
    public function __construct()
    {
        $this->middleware('permission:question-list|question-create|question-edit|question-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:question-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:question-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:question-delete', ['only' => ['destroy']]);
    }

    public function create(Assessment $assessment)
    {
        return view('admin.questions.create', compact('assessment'));
    }

    public function store(Request $request, Assessment $assessment)
    {
        Log::info('Store method called.');
        Log::info('Request data: ', $request->all());

        $validatedData = $request->validate([
            'question' => 'required|string|max:255',
            'answers.*' => 'required|string|max:255',
            'correct_answer' => 'required|integer|in:1,2,3,4',
        ]);

        Log::info('Validated data: ', $validatedData);

        $question = new Question([
            'question' => $validatedData['question'],
            'assessment_id' => $assessment->id,
        ]);
        $question->save();

        foreach ($request->input('answers') as $key => $answer) {
            $isCorrect = ($key + 1) == $validatedData['correct_answer'];
            $question->answers()->create([
                'answer' => $answer,
                'is_correct' => $isCorrect,
            ]);
        }

        return redirect()->route('assessments.index', $assessment->id);
    }


    public function edit(Assessment $assessment, Question $question)
    {
        return view('admin.questions.edit', compact('assessment', 'question'));
    }

    public function update(Request $request, Assessment $assessment, Question $question)
    {
        $request->validate([
            'question' => 'required|string',
        ]);

        try {
            $question->update($request->all());
            return redirect()->route('assessments.show', $assessment->id)->with('success', 'Question updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error updating question: ' . $e->getMessage());
            return back()->with('error', 'There was an error updating the question.');
        }
    }

    public function destroy(Assessment $assessment, Question $question)
    {
        try {
            $question->delete();
            return redirect()->route('assessments.show', $assessment->id)->with('success', 'Question deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting question: ' . $e->getMessage());
            return back()->with('error', 'There was an error deleting the question.');
        }
    }
}

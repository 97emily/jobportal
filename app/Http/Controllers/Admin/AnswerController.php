<?php
// app/Http/Controllers/AnswerController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Answer;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    public function create(Question $question)
    {
        return view('admin.answers.create', compact('question'));
    }

    public function store(Request $request, Question $question)
    {
        $request->validate([
            'answer' => 'required|string',
            'is_correct' => 'required|boolean',
        ]);

        $question->answers()->create($request->all());
        return redirect()->route('assessments.show', $question->assessment->id)->with('success', 'Answer added successfully.');
    }

    public function edit(Question $question, Answer $answer)
    {
        return view('admin.answers.edit', compact('question', 'answer'));
    }

    public function update(Request $request, Question $question, Answer $answer)
    {
        $request->validate([
            'answer' => 'required|string',
            'is_correct' => 'required|boolean',
        ]);

        $answer->update($request->all());
        return redirect()->route('assessments.show', $question->assessment->id)->with('success', 'Answer updated successfully.');
    }

    public function destroy(Question $question, Answer $answer)
    {
        $answer->delete();
        return redirect()->route('assessments.show', $question->assessment->id)->with('success', 'Answer deleted successfully.');
    }
}


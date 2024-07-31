<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PracticalQuestion;
use App\Models\PracticalTest;
use Illuminate\Http\Request;

class PracticalQuestionController extends Controller
{
    public function index()
    {

        $questions = PracticalQuestion::latest()->paginate(5);
        return view('admin.practical_questions.index', compact('questions'))
        ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        $tests = PracticalTest::all();
        return view('admin.practical_questions.create' , compact('tests'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'practical_tests_id' => 'required|exists:practical_tests,id',
            'question' => 'required|string',
        ]);

        PracticalQuestion::create($request->all());

        return redirect()->route('practical_questions.index');
    }

    public function show(PracticalQuestion $practicalQuestion)
    {
        $tests = PracticalTest::all();
        return view('admin.practical_questions.show', compact('practicalQuestion','tests'));
    }

    public function edit(PracticalQuestion $practicalQuestion)
    {
        $tests = PracticalTest::all();
        return view('admin.practical_questions.edit', compact('practicalQuestion', 'tests' ));
    }

    public function update(Request $request, PracticalQuestion $practicalQuestion)
    {
        $request->validate([
            'test_id' => 'required|exists:practical_tests,id',
            'question' => 'required|string',
        ]);

        $practicalQuestion->update($request->all());

        return redirect()->route('practical_questions.index');
    }

    public function destroy(PracticalQuestion $practicalQuestion)
    {
        $practicalQuestion->delete();

        return redirect()->route('practical_questions.index');
    }
}


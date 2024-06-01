<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Assessment;
use App\Models\JobListing;
use App\Models\Question;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class AssessmentController extends Controller
{
    public function index()
    {
        $assessments = Assessment::with('questions.answers')->paginate(10);
        return view('admin.assessments.index', compact('assessments'));
    }

    public function create()
    {
        return view('assessments.create');
    }

    public function store(Request $request)
    {
        $assessment = Assessment::create($request->only('title', 'description', 'job_listing_id'));

        foreach ($request->questions as $questionData) {
            $question = new Question(['question' => $questionData['question']]);
            $assessment->questions()->save($question);

            foreach ($questionData['answers'] as $answerData) {
                $answer = new Answer(['answer' => $answerData['answer'], 'is_correct' => $answerData['is_correct']]);
                $question->answers()->save($answer);
            }
        }

        return redirect()->route('assessments.index');
    }

    public function show(Assessment $assessment)
    {
        $assessment->load('questions.answers');
        return view('admin.assessments.index', compact('assessment'));
    }
}

// class AssessmentController extends Controller
// {
//     public function __construct()
//     {
//         $this->middleware('permission:assessment-list|assessment-create|assessment-edit|assessment-delete', ['only' => ['index', 'show']]);
//         $this->middleware('permission:assessment-create', ['only' => ['create', 'store']]);
//         $this->middleware('permission:assessment-edit', ['only' => ['edit', 'update']]);
//         $this->middleware('permission:assessment-delete', ['only' => ['destroy']]);
//     }

//     public function index()
//     {
//         $assessments = Assessment::withCount('questions')->paginate(10);
//         return view('admin.assessments.index', compact('assessments'));
//     }

//     public function create()
//     {
//         $jobs = JobListing::all();
//         return view('admin.assessments.create', compact('jobs'));
//     }

//     public function store(Request $request)
//     {
//         $request->validate([
//             'title' => 'required|string|max:255',
//             'description' => 'nullable|string',
//             'job_listings_id' => 'required|exists:job_listings,id',
//         ]);

//         return redirect()->route('assessments.index')->with('success', 'Assessment created successfully.');
//     }

//     public function show(Assessment $assessment)
//     {
//         return view('admin.assessments.show', compact('assessment'));
//     }

//     public function edit(Assessment $assessment)
//     {
//         $jobs = JobListing::all();
//         return view('admin.assessments.edit', compact('assessment', 'jobs'));
//     }

//     public function update(Request $request, Assessment $assessment)
//     {
//         $request->validate([
//             'title' => 'required|string|max:255',
//             'description' => 'nullable|string',
//             'job_listings_id' => 'required|exists:job_listings,id',
//         ]);

//         $assessment->update($request->all());
//         return redirect()->route('assessments.index')->with('success', 'Assessment updated successfully.');
//     }

//     public function destroy(Assessment $assessment)
//     {
//         $assessment->delete();
//         return redirect()->route('assessments.index')->with('success', 'Assessment deleted successfully.');
//     }
// }

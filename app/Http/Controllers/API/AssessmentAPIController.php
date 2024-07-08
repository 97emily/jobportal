<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AssessmentAPIController extends Controller
{
    public function index(): JsonResponse
    {
        $assessments = Assessment::latest()->paginate(config('constants.posts_per_page'));
        return response()->json($assessments);
    }

    public function show(Request $request): JsonResponse
    {
        $assessment_id = $request->input('assessment_id');
        $assessment = Assessment::with(['category', 'questions'])->where('id', $assessment_id)->latest()->first();

        // $user_id=$request->input('user_id');
        // $user=User::with('user')->where('id', $user_id)->latest()->first();
        // if (!$user) {
        //     return response()->json(['error' => 'user Id not found'], 404);
        // }

        if (!$assessment) {
            return response()->json(['error' => 'Assessment Id not found'], 404);
        }

        $totalAllocatedMarks = $assessment->questions->sum('allocated_marks');
        $totalTimeRequired = $assessment->questions->sum('allocated_time');

        // Calculate the pass mark in marks form
        $computedPassMarkInMarks = $totalAllocatedMarks ? ($assessment->pass_mark / 100) * $totalAllocatedMarks : 0;

        $response = [
            'title' => $assessment->title,
            'description' => $assessment->description,
            'pass_mark' => $assessment->pass_mark . '%', // The pass mark saved in the assessment
            'total_allocated_marks' => $totalAllocatedMarks,
            'total_time_required_in_minutes' => $totalTimeRequired,
            'computed_pass_mark_in_marks' => round($computedPassMarkInMarks, 2), // Pass mark in marks form
            'category' => $assessment->category ? $assessment->category->name : 'Not specified',
            'questions' => $assessment->questions->map(function($question) {
                    return [
                        // 'id' => $question->id,
                        'question' => strip_tags($question->question),
                        'allocated_marks' => $question->allocated_marks,
                        // 'allocated_time' => $question->allocated_time,
                        'multiple_choices' => assessments_choices($question->id),
                        'correct_answer' => assessments_answers($question->id),
                    ];
                }),

        ];

        return response()->json($response);
    }
}

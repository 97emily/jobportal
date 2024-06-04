<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Assessment;
use App\Models\Question;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Ensure there are assessments in the database
        $assessmentIds = Assessment::pluck('id');

        if ($assessmentIds->isEmpty()) {
            // Create assessments if none exist
            $assessment = Assessment::factory()->create();
            $assessmentIds = collect([$assessment->id]);
        }

        // Create questions linked to existing assessments
        Question::factory()
            ->count(50)
            ->make()
            ->each(function ($question) use ($assessmentIds) {
                $question->assessment_id = $assessmentIds->random();
                $question->save();
            });
    }
}

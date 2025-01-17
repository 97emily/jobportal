<?php

namespace Database\Factories;

use App\Models\Answer;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnswerFactory extends Factory
{
    protected $model = Answer::class;

    public function definition()
    {
        return [
            'question_id' => \App\Models\Question::factory(), 
            'answer' => $this->faker->sentence,
            'is_correct' => $this->faker->boolean,
        ];
    }
}

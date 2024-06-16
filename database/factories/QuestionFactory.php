<?php

namespace Database\Factories;

use App\Models\Question;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    // protected $model = Question::class;

    // /**
    //  * Define the model's default state.
    //  *
    //  * @return array
    //  */
    // public function definition()
    // {
    //     return [
    //         'assessment_id' => \App\Models\Assessment::inRandomOrder()->first()->id,
    //         'question' => $this->faker->sentence,
    //         'created_at' => now(),
    //         'updated_at' => now(),
    //     ];
    // }

    protected $model = Question::class;

    public function definition()
    {
        return [
            'question' => $this->faker->sentence,
            'allocated_marks' => $this->faker->numberBetween(1, 10),
            'allocated_time' => $this->faker->numberBetween(1, 60),
            'multiple_choices' => json_encode($this->faker->words(4)),
            'marking_scheme' => json_encode(['correct' => $this->faker->numberBetween(1, 4)]),
            // 'assessment_id' => Assessment::factory(),
            'assessment_id' => \App\Models\Assessment::inRandomOrder()->first()->id,
        ];
    }
}

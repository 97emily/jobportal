<?php

namespace Database\Factories;

use App\Models\Assessment;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\JobListing;

class AssessmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    // protected $model = Assessment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    // public function definition()
    // {
    //     return [
    //         'title' => $this->faker->sentence(4),
    //         'description' => $this->faker->paragraph,
    //         'job_listings_id' => \App\Models\JobListing::inRandomOrder()->first()->id,
    //         'created_at' => now(),
    //         'updated_at' => now(),
    //     ];
    // }

    protected $model = Assessment::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'pass_mark' => $this->faker->numberBetween(50, 100),
            // 'category_id' => Category::factory()
            'category_id' => \App\Models\Category::inRandomOrder()->first()->id,
        ];
    }
}

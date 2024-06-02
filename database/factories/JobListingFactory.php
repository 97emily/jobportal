<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\JobListing;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JobListing>
 */
class JobListingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    // public function definition(): array
    // {
    //     return [
    //         //
    //     ];
    // }

    protected $model = JobListing::class;

    public function definition()
    {
        return [
            'title' => $this->faker->jobTitle,
            'job_description' => $this->faker->paragraphs(3, true),
            'status' => $this->faker->randomElement(['open', 'preview', 'closed']),
            'closing_date' => $this->faker->dateTimeBetween('now', '+1 year'),
            'tag_id' => \App\Models\Tag::inRandomOrder()->first()->id,
            'category_id' => \App\Models\Category::inRandomOrder()->first()->id,
            'location' => $this->faker->city,
            'salary_min' => $this->faker->randomFloat(2, 30000, 50000),
            'salary_max' => $this->faker->randomFloat(2, 50000, 100000),
            'employment_type' => $this->faker->randomElement(['full-time', 'part-time', 'contract', 'temporary', 'internship']),
            'experience_level' => $this->faker->randomElement(['entry', 'mid', 'senior', 'executive']),
            'education_requirements' => $this->faker->sentence,
            'assessment_test' => $this->faker->word,
            'threshold_score' => $this->faker->numberBetween(50, 100),
        ];
    }
}

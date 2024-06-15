<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Assessment;
use App\Models\JobListing;

class AssessmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Ensure there are job listings in the database
        $jobListingIds = JobListing::pluck('id');

        if ($jobListingIds->isEmpty()) {
            // Create a job listing if none exist
            $jobListing = JobListing::create([
                'title' => 'Sample Job Listing Title',
                'description' => 'Sample Job Listing Description',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $jobListingIds = collect([$jobListing->id]);
        }

        // Create assessments linked to existing job listings
        Assessment::factory()
            ->count(10)
            ->make()
            ->each(function ($assessment) use ($jobListingIds) {
                $assessment->job_listings_id = $jobListingIds->random();
                $assessment->save();
            });
    }
}

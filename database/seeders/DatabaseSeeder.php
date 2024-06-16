<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */

    public function run(): void
    {
        $this->call([
            PermissionTableSeeder::class,
            CreateAdminUserSeeder::class,
            CategorySeeder::class,
            SalaryRangeSeeder::class,
            LocationSeeder::class,
            AssessmentSeeder::class,
            QuestionSeeder::class,
            TagSeeder::class,
            JobListingSeeder::class,
            // AnswerSeeder::class,
        ]);
    }
}

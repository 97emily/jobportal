<?php

namespace Database\Seeders;

use App\Models\Category;

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            "Information Technology",
            "Finance and Accounting",
            "Software Development",
            "Human Resources",
            "Marketing",
            "Sales",
            "Customer Service",
            "Project Management",
            "Business Development",
            "Operations Management",
            "Consulting",
            "Data Analysis",
            "Graphic Design",
            "Content Creation",
            "Research and Development",
            "Legal Services",
            "Healthcare",
            "Education",
            "Manufacturing",
            "Retail",
            "Hospitality",
            "Construction",
            "Transportation and Logistics",
            "Media and Entertainment",
            "Nonprofit and Social Services",
            "Government and Public Administration"
        ];

        foreach ($categories as $cat) {
            Category::create(['name' => $cat]);
        }
    }
}

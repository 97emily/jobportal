<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SalaryRange;

class SalaryRangeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SalaryRange::factory()->count(10)->create();
    }
}


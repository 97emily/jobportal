<?php

namespace Database\Factories;

use App\Models\SalaryRange;
use Illuminate\Database\Eloquent\Factories\Factory;

class SalaryRangeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SalaryRange::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $minimum = $this->faker->numberBetween(30000, 70000);
        $maximum = $this->faker->numberBetween($minimum + 5000, 120000);

        return [
            'minimum' => $minimum,
            'maximum' => $maximum,
        ];
    }
}

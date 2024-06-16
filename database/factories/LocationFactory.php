<?php

namespace Database\Factories;

use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

class LocationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Location::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->company,
            // 'address' => $this->faker->address,
            // 'city' => $this->faker->city,
            // 'state' => $this->faker->state,
            // 'country' => $this->faker->country,
            // 'postal_code' => $this->faker->postcode,
        ];
    }
}

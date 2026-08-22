<?php

namespace Database\Factories;

use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Vehicle>
 */
class VehicleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'brand' => $this->faker->word(),
            'model' => $this->faker->word(),
            'color' => $this->faker->colorName(),
            'plate' => strtoupper($this->faker->bothify('???#?##')),
        ];
    }
}

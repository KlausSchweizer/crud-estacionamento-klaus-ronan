<?php

namespace Database\Factories;

use App\Models\Parking;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Parking>
 */
class ParkingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $entrada = fake()->dateTimeBetween('-1 month', 'now');
        $saida = fake()->dateTimeBetween($entrada, 'now');

        return [
            'vehicles_id' => Vehicle::factory(),

            'horario_entrada' => $entrada->format('H:i:s'),

            'horario_saida' => $saida->format('H:i:s'),

            'preco' => fake()->randomFloat(2, 5, 100),
        ];
    }
}

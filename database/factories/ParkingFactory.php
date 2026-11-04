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

        $saiu = fake()->boolean(50);

        if ($saiu) {
            $saida = fake()->dateTimeBetween($entrada, 'now');
            $preco = fake()->randomFloat(2, 5, 100);
        } else {
            $saida = null;
            $preco = null;
        }

        return [
            'vehicles_id' => Vehicle::factory(),

            'spots_id' => Spot::inRandomOrder()->first() ?? Spot::factory(),

            'horario_entrada' => $entrada->format('H:i:s'),

            'horario_saida' => $saida ? $saida->format('H:i:s') : null,

            'preco' => $preco,
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Spot;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Spot>
 */
class SpotFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected static int $index = 0;
    protected static int $row = 0;
    public function definition(): array
    {
        $rows = ['A', 'B', 'C', 'D', 'E'];

        $obj = [
            'row' => $rows[self::$row],
            'index' => self::$index,
        ];

        self::$index++;

        if (self::$index > 5) {
            self::$index = 1;
            self::$row++;

            if (self::$row >= count($rows)) {
                self::$row = 0;
            }
        }

        return $obj;
    }
}

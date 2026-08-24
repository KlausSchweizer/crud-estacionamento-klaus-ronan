<?php

namespace Database\Seeders;

use App\Models\Parking;
use Illuminate\Database\Seeder;

class ParkingSeeder extends Seeder
{
    public function run(): void
    {
        Parking::factory()->count(20)->create();
    }
}
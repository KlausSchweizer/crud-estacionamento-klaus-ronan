<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(10)->create();

        if (!User::where('email', 'admin@exemplo.com')->exists()) {
            User::factory()->create([
                'username' => 'Test User',
                'email' => 'admin@exemplo.com',
                'password' => bcrypt('123456'),
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Tailwebs Teacher',
            'email' => 'teacher@tailwebs.com',
            'password' => '$2y$12$kjaV3YdtQ5HCzLNKqPvO9.3pdR/vQEYC6w8Bw2lY1veJC8sY3KhvO',
        ]);
    }
}
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
            'name' => 'Dotanin Dev',
            'email' => 'dotanin@dev.com',
            'balance' => 100
        ]);

        $this->call([
            DeviceSeeder::class,
            ServiceSeeder::class
        ]);
    }
}

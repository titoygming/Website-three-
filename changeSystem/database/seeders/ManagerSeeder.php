<?php

namespace Database\Seeders;

use App\Models\Manager;
use Illuminate\Database\Seeder;

class ManagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Manager::query()->create([
            'name'=>'Manager',
            'email'=>'manager@system.com',
            'password' => bcrypt('password')
        ]);
    }
}

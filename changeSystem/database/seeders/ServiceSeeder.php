<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Service::query()->create([
            'name' => 'Unlock network via imei',
            'price' => 50
        ]);

        Service::query()->create([
            'name' => 'Bypass A12',
            'price' => 100
        ]);
    }
}

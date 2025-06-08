<?php

namespace Database\Seeders;

use App\Models\RoutePoint;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoutePointSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RoutePoint::insert([
            [
                'route_id' => 1,
                'order' => 1,
                'latitude' => -6.200000,
                'longitude' => 106.816666,
                'name' => 'Station A',
                'address' => 'Jl. Sudirman, Jakarta',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'route_id' => 1,
                'order' => 2,
                'latitude' => -6.210000,
                'longitude' => 106.826666,
                'name' => 'Station B',
                'address' => 'Jl. Thamrin, Jakarta',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\BusLocation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BusLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BusLocation::insert([
            [
                'bus_id' => 1,
                'latitude' => -6.201111,
                'longitude' => 106.820000,
                'speed' => 30.5,
                'heading' => 90.0,
                'device_time' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}

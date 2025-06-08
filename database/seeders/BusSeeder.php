<?php

namespace Database\Seeders;

use App\Models\Bus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Bus::insert([
            [
                'plate_number' => 'B 1234 XYZ',
                'brand' => 'Mercedes',
                'model' => 'Sprinter',
                'capacity' => 40,
                'driver_id' => 'DRV001',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'plate_number' => 'B 5678 ABC',
                'brand' => 'Toyota',
                'model' => 'Coaster',
                'capacity' => 30,
                'driver_id' => 'DRV002',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}

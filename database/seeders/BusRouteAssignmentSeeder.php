<?php

namespace Database\Seeders;

use App\Models\BusRouteAssignment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BusRouteAssignmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BusRouteAssignment::insert([
            [
                'bus_id' => 1,
                'route_id' => 1,
                'schedule_start' => '06:00:00',
                'schedule_end' => '08:00:00',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}

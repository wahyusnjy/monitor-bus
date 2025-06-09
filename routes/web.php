<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/test-broadcast', function () {
    $bus = \App\Models\Bus::firstOrCreate([
        'plate_number' => 'B1234XYZ'
    ], [
        'brand' => 'Test',
        'model' => 'Bus',
        'capacity' => 40
    ]);
    
    $latitude = -6.2 + (rand(-100, 100) / 1000);
    $longitude = 106.8 + (rand(-100, 100) / 1000);
    
    $location = $bus->locations()->create([
        'latitude' => $latitude,
        'longitude' => $longitude,
        'speed' => rand(30, 60),
        'heading' => rand(0, 360),
        'device_time' => now()
    ]);
    
    event(new \App\Events\BusLocationUpdated($bus, $location, null));
    
    return "Broadcast sent! Lat: $latitude, Lng: $longitude";
});
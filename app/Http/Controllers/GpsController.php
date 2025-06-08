<?php

namespace App\Http\Controllers;

use App\Events\BusLocationUpdated;
use App\Models\Bus;
use Illuminate\Http\Request;

class GpsController extends Controller
{
    public function handleGpsUpdate(Request $request)
    {
        $validated = $request->validate([
            'device_id' => 'required|exists:buses,plate_number',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'speed' => 'nullable|numeric|min:0',
            'heading' => 'nullable|numeric|between:0,360',
            'timestamp' => 'required|date'
        ]);

        $bus = Bus::where('plate_number', $validated['device_id'])->first();

        $location = $bus->locations()->create([
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
            'speed' => $validated['speed'] ?? null,
            'heading' => $validated['heading'] ?? null,
            'device_time' => $validated['timestamp']
        ]);

        // Broadcast event ke channel realtime
        event(new BusLocationUpdated(
            $bus,
            $location,
            $bus->activeRoute
        ));

        return response()->json([
            'status' => 'success',
            'message' => 'Location updated',
            'data' => $location
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\BusLocation;
use Illuminate\Http\Request;

class BusController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => Bus::with(['currentLocation', 'activeRoutes'])->get()
        ]);
    }

    public function activeBuses()
    {
        return response()->json([
            'data' => Bus::with(['currentLocation', 'activeRoutes'])
                ->where('is_active', true)
                ->get()
        ]);
    }

    public function locationHistory(Bus $bus)
    {
        $locations = $bus->locations()
            ->orderBy('device_time', 'desc')
            ->paginate(50);

        return response()->json([
            'data' => $locations
        ]);
    }

    public function nearbyBuses(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'radius' => 'required|numeric|min:100' // dalam meter
        ]);

        $locations = BusLocation::with('bus')
            ->whereHas('bus', function ($query) {
                $query->where('is_active', true);
            })
            ->withinRadius(
                $request->latitude,
                $request->longitude,
                $request->radius
            )
            ->orderBy('device_time', 'desc')
            ->get()
            ->unique('bus_id');

        return response()->json([
            'data' => $locations->map(function ($location) {
                return [
                    'bus' => $location->bus,
                    'location' => $location
                ];
            })
        ]);
    }
}

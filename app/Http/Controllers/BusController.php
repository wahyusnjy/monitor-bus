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
            'data' => Bus::with(['currentLocation', 'activeRoutes', 'activeRoutes.points'])->get()
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
            'lng' => 'required|numeric',
            'lat' => 'required|numeric',
            'radius' => 'required|numeric' // dalam meter
        ]);

        $locations = BusLocation::with('bus')
            ->whereHas('bus', function ($query) {
                $query->where('is_active', true);
            })
            ->withinRadius(
                $request->lat,
                $request->lng,
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

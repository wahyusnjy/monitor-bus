<?php

namespace App\Http\Controllers;

use App\Models\Route;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => Route::with(['points', 'activeBuses.currentLocation'])
                ->where('is_active', true)
                ->get()
        ]);
    }

    public function show(Route $route)
    {
        return response()->json([
            'data' => $route->load([
                'points',
                'activeBuses.currentLocation'
            ])
        ]);
    }
}

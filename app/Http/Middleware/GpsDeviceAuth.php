<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GpsDeviceAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        $deviceKey = $request->header('X-Device-Key');
        $validKey = config('services.gps.device_key');

        if (!$deviceKey || $deviceKey !== $validKey) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized device'
            ], 401);
        }

        return $next($request);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusLocation extends Model
{
    protected $fillable = [
        'bus_id', 'latitude', 'longitude',
        'speed', 'heading', 'device_time'
    ];

    protected $casts = [
        'device_time' => 'datetime',
        'latitude' => 'float',
        'longitude' => 'float',
        'speed' => 'float',
        'heading' => 'float'
    ];

    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }

    // MySQL spatial query (gunakan dengan MySQL 5.7+)
    public function scopeWithinRadius($query, $lat, $lng, $radius)
    {
        return $query->whereRaw("
            ST_Distance_Sphere(
                POINT(longitude, latitude),
                POINT(?, ?)
            ) <= ?", [$lng, $lat, $radius]);
    }

    // Untuk MySQL versi lama (5.6 atau dibawah)
    public function scopeApproxWithinRadius($query, $lat, $lng, $radius)
    {
        $earthRadius = 6371000; // meters
        $latDistance = $radius / $earthRadius;
        $lngDistance = $radius / ($earthRadius * cos(pi() * $lat / 180));

        $minLat = $lat - rad2deg($latDistance);
        $maxLat = $lat + rad2deg($latDistance);
        $minLng = $lng - rad2deg($lngDistance);
        $maxLng = $lng + rad2deg($lngDistance);

        return $query->whereBetween('latitude', [$minLat, $maxLat])
                     ->whereBetween('longitude', [$minLng, $maxLng]);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    protected $fillable = [
        'plate_number', 'brand', 'model',
        'capacity', 'driver_id', 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function locations()
    {
        return $this->hasMany(BusLocation::class);
    }

    public function currentLocation()
    {
        return $this->hasOne(BusLocation::class)->latestOfMany();
    }

    public function activeRoutes()
    {
        return $this->belongsToMany(Route::class, 'bus_route_assignments')
                   ->wherePivot('is_active', true)
                   ->withPivot(['schedule_start', 'schedule_end']);
    }

    public function getActiveRouteAttribute()
    {
        return $this->activeRoutes()->first();
    }
}

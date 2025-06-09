<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Route extends Model
{
    protected $fillable = ['name', 'description', 'is_active'];

    public function points(): HasMany
    {
        return $this->hasMany(RoutePoint::class)->orderBy('order');
    }

    public function buses(): BelongsToMany
    {
        return $this->belongsToMany(Bus::class)
            ->withPivot(['schedule_start', 'schedule_end'])
            ->withTimestamps();
    }


    public function activeBuses()
    {
        return $this->belongsToMany(Bus::class, 'bus_route_assignments')
                ->wherePivot('is_active', true)
                ->withPivot(['schedule_start', 'schedule_end']);
    }

    public function getPathAttribute()
    {
        return $this->points->map(function ($point) {
            return [
                'lat' => $point->latitude,
                'lng' => $point->longitude,
                'name' => $point->name
            ];
        });
    }

}

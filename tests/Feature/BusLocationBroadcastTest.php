<?php

namespace Tests\Feature;

use App\Events\BusLocationUpdated;
use App\Models\Bus;
use App\Models\BusLocation;
use App\Models\Route;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class BusLocationBroadcastTest extends TestCase
{
    use RefreshDatabase;

    public function test_bus_location_broadcast()
    {
        Event::fake();
        
        $bus = Bus::factory()->create();
        $route = Route::factory()->create();
        $bus->activeRoutes()->attach($route);
        
        $location = BusLocation::factory()->create([
            'bus_id' => $bus->id
        ]);
        
        event(new BusLocationUpdated($bus, $location, $route));
        
        Event::assertDispatched(function (BusLocationUpdated $event) use ($bus, $location) {
            return $event->bus->id === $bus->id &&
                   $event->location->id === $location->id;
        });
    }
}

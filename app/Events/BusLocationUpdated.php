<?php

namespace App\Events;

use App\Models\Bus;
use App\Models\BusLocation;
use App\Models\Route;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BusLocationUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $bus;
    public $location;
    public $route;

    public function __construct(Bus $bus, BusLocation $location, ?Route $route)
    {
        $this->bus = $bus;
        $this->location = $location;
        $this->route = $route;
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('bus.'.$this->bus->id),
            new Channel('route.'.$this->route->id), // Jika ada rute
            new Channel('public.buses') // Channel publik
        ];
    }

    public function broadcastWith()
    {
        return [
            'bus' => [
                'id' => $this->bus->id,
                'plate_number' => $this->bus->plate_number,
                'brand' => $this->bus->brand,
                'model' => $this->bus->model
            ],
            'location' => [
                'latitude' => $this->location->latitude,
                'longitude' => $this->location->longitude,
                'speed' => $this->location->speed,
                'heading' => $this->location->heading,
                'timestamp' => $this->location->device_time
            ],
            'route' => $this->route ? [
                'id' => $this->route->id,
                'name' => $this->route->name,
                'code' => $this->route->code
            ] : null
        ];
    }

    public function broadcastAs()
    {
        return 'location.updated';
    }
}

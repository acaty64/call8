<?php

namespace App\Events;

use App\Models\Window;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RingEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function broadcastWith()
    {
        $window = \Auth::user()->window;
        return [
            'status' => $window->status->status,
            'host' => $window->host->name,
            'client_id' => $window->client_id,
            'link' => $window->link,
        ];
    }

    public function broadcastOn()
    {
        return new Channel('channel-ring');
    }
}

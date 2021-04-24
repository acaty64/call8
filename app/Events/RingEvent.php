<?php

namespace App\Events;

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

    // public $data;

    // public function __construct()
    // {
    //     $this->data = $data;
    // }

    // public function broadcastWith()
    // // public function broadcastWith($data)
    // {
    //     // return ['Emitiendo'];
    //     return [
    //         'data' => $this->data
    //     ];
    // }

    public function broadcastOn()
    {
        // return 'channel-ring';
        return new Channel('channel-ring');
        // return new PrivateChannel('channel-name');
    }
}

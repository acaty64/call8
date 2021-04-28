<?php

namespace App\Events;

use App\Models\Call;
use App\Models\Status;
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

    public $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function broadcastWith()
    {
        $status_paused = Status::where('status', 'En Pausa')->first();
        $qwindows = Window::where('host_id', '!=', null)->count();
        $status_paused = Status::where('status', 'En Pausa')->first();
        $qclients = Call::where('status_id', $status_paused->id)->count();
        $window = \Auth::user()->window;
        if(!$window){
            return [
                'status' => null,
                'host' => null,
                'host_id' => null,
                'client' => null,
                'client_id' => null,
                'link' => null,
                'message' => $this->message,
                'qclients' => $qclients,
                'qwindows' => $qwindows,
            ];
        }
        return [
            'status' => $window->status->status,
            'host' => $window->host->name,
            'host_id' => $window->host_id,
            'client' => is_null($window->client) ? '' : $window->client->name,
            'client_id' => is_null($window->client) ? '' : $window->client_id,
            'link' => $window->link,
            'message' => $this->message,
            'qclients' => $qclients,
            'qwindows' => $qwindows,
        ];
    }

    public function broadcastOn()
    {
        return new Channel('channel-ring');
    }
}

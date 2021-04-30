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

class Ring3Event implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    // public $message;

    // public function __construct($message)
    // {
    //     $this->message = $message;
    // }

    // public function broadcastWith()
    // {
    //     $window = \Auth::user()->window;
    //     if(!$window){
    //         $window = new Window;
    //         return [
    //             'status' => null,
    //             'host' => null,
    //             'host_id' => null,
    //             'client' => null,
    //             'client_id' => null,
    //             'link' => null,
    //             'call_id' => null,
    //             'message' => $this->message,
    //             // 'qclients' => $window->qclients,
    //             // 'qwindows' => $window->qwindows,
    //         ];
    //     }
    //     return [
    //         'status' => $window->status->status,
    //         'host' => $window->host->name,
    //         'host_id' => $window->host_id,
    //         'client' => is_null($window->client) ? '' : $window->client->name,
    //         'client_id' => is_null($window->client) ? '' : $window->client_id,
    //         'link' => $window->link,
    //         'message' => $window->message,
    //         // 'qclients' => $window->qclients,
    //         // 'qwindows' => $window->qwindows,
    //         'call_id' => $window->call_id,
    //     ];
    // }

    public function broadcastOn()
    {
        return new PresenceChannel('presence-ring');
    }
}

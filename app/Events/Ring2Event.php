<?php

namespace App\Events;

use App\Models\Call;
use App\Models\Status;
use App\Models\Window;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Ring2Event implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->window_id = $data['window_id'];
        $this->host_id = $data['host_id'];
        $this->client_id = $data['client_id'];
        $this->call_id = $data['call_id'];
        $this->message = $data['message'];
    }

    public function broadcastWith()
    {
        if(!$this->window_id){
            return [
                'status' => null,
                'host' => null,
                'host_id' => null,
                'client' => null,
                'client_id' => null,
                'link' => null,
                'call_id' => null,
                'office_id' => null,
                'message' => $this->message,
                'window' => null,
            ];
        }
        $window = Window::find($this->window_id);
        return [
            'status' => $window->status->status,
            'host' => $window->host->name,
            'host_id' => $window->host_id,
            'client' => is_null($window->client) ? '' : $window->client->name,
            'client_id' => is_null($window->client) ? '' : $window->client_id,
            'link' => $window->link,
            'message' => $window->mensaje,
            'call_id' => $window->call_id,
            'office_id' => $window->office_id,
            'window' => $window,
        ];
    }

    public function broadcastOn()
    {
        return new PrivateChannel('channel-ring');
    }
}

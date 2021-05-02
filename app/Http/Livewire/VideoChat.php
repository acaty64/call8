<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Http\Request;
use Livewire\Component;
use Pusher\Pusher;

class IndexChat extends Component
{
    // public function render(Request $request)
    public function render()
    {
        $user = \Auth::user();
        $others = User::where('id', '!=', $user->id)->pluck('name', 'id');
        return view('livewire.video-chat')->with([
            'user' => collect($user()->only(['id', 'name'])),
            'other' => $others->first()
        ]);
    }

    public function auth(Request $request)
    {
        $user = $request->user();
        $socket_id = $request->socket_id;
        $channel_name = $request->channel_name;
        $pusher = new Pusher(
            config('broadcasting.connections.pusher.key'),
            config('broadcasting.connections.pusher.secret'),
            config('broadcasting.connections.pusher.app_id'),
            [
                'cluster' => config('broadcasting.connections.pusher.options.cluster'),
                'encrypted' => true
            ]
        );
        return response(
            $pusher->presence_auth($channel_name, $socket_id, $user->id)
        );
    }
}

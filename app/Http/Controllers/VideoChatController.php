<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Pusher\Pusher;

class VideoChatController extends Controller
{
    public function index_0(Request $request) {
        $user = $request->user();
        $others = User::where('id', '!=', $user->id)->pluck('name', 'id');
        return view('app.video.index_0')->with([
            'user' => collect($request->user()->only(['id', 'name'])),
            'others' => $others
        ]);
    }

    public function index(Request $request) {
        $user = $request->user;

        $others = User::where('id', '!=', $user->id)->pluck('name', 'id');

        if(\Auth::user()->id == 1){
            $other = User::find($request->other->id);
        }

        if(\Auth::user()->id == 2){
            $other = User::find(1);
        }

        return view('app.video.index')->with([
            'user' => collect($request->user()->only(['id', 'name'])),
            'others' => $others,
            'other' => $other,
        ]);
    }

    public function index1($user_id, $other_id) {

        $user = User::find($user_id);

        $other = User::find($other_id);

        return view('app.video.index')->with([
            'user' => $user,
            'other' => $other,
        ]);
    }

    public function auth_0(Request $request) {
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

    public function auth(Request $request) {
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
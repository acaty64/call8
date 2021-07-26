<?php
namespace App\Http\Controllers;
use App\Models\Call;
use App\Models\Document;
use App\Models\User;
use Illuminate\Http\Request;
use Pusher\Pusher;

class VideoChatController extends Controller
{

    public function index($user_id, $other_id, $call_id) {
        $user = User::find($user_id);
        $other = User::find($other_id);
        $call = Call::find($call_id);
        $documents = Document::where('active', 1)->orderBy('order')->get();

// dd($documents->toJson());
        foreach ($documents as $doc) {
            $doc->link = '/storage/docs/' . basename($doc->link);
        }

        return view('app.video.jitsi')->with([
            'user' => $user,
            'other' => $other,
            'call' => $call,
            'documents' => $documents->toJson()
        ]);
        // return view('app.video.index')->with([
        //     'user' => $user,
        //     'other' => $other,
        //     'call' => $call,
        // ]);
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
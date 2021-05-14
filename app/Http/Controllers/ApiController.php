<?php

namespace App\Http\Controllers;

use App\Http\Traits\WindowTrait;
use App\Models\Call;
use App\Models\Comment;
use App\Models\User;
use App\Models\Window;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    use WindowTrait;

    public function stopWindow($window_id)
    {
    	$window = Window::find($window_id);
    	$response = $this->window_stop($window_id);
    	return $response;
    }

    public function getComments($call_id)
    {
        $call = Call::find($call_id);
        $data = Comment::where('client_id', $call->client_id)->orderBy('id', 'desc')->get();
        $comments = [];
        $n = 0;
        foreach ($data as $item)
        {
            if($n < 5){
                $date = new Carbon($item->created);

                $comments[] = [
                    'date' => $date->format('l d M Y H:m'),
                    'client' => $item->client->name,
                    'host' => $item->host->name,
                    'client_comment' => $item->client_comment,
                    'host_comment' => $item->host_comment,
                ];
            }
        }
        return $comments;
    }

    public function saveComments(Request $request)
    {
        $comment = Comment::create([
            'call_id' => $request->call_id,
            'host_id' => $request->host_id,
            'client_id' => $request->client_id,
            'host_comment' => $request->host_comment,
            'client_comment' => $request->client_comment,
        ]);

        $data = Comment::where('client_id', $request->client_id)->orderBy('id', 'desc')->get();
        $comments = [];
        $n = 0;
        foreach ($data as $item)
        {
            if($n < 5){
                $date = new Carbon($item->created);

                $comments[] = [
                    'date' => $date->format('l d M Y H:m'),
                    'client' => $item->client->name,
                    'host' => $item->host->name,
                    'client_comment' => $item->client_comment,
                    'host_comment' => $item->host_comment,
                ];
            }
        }
        return [
            'success' => true,
            'comments' => $comments,
        ];

    }

    //// ?????????????? HACE LO MISMO ??????????????? ////////////
    public function sendStop($window_id)
    {
    	$response = $this->window_stop($window_id);
    	return $response;
    }
    //// ?????????????? HACE LO MISMO ??????????????? ////////////

}

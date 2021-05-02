<?php

namespace App\Http\Livewire;

use App\Events\Ring2Event;
use App\Events\RingEvent;
use App\Http\Traits\WindowTrait;
use App\Models\User;
use App\Models\Window;
use Livewire\Component;

class HostScreen extends Component
{

    use WindowTrait;

	public $qwindows;
    public $qclients;
	public $status;
    public $window;
    public $link;
    public $data_test;
    public $message;
    public $client;
    public $host;

    protected $listeners = [

        'echo-private:channel-ring,Ring2Event' => 'ring',
        'echo-presence:presence-ring,here' => 'here',
        'echo-presence:presence-ring,joining' => 'joining',
        'echo-presence:presence-ring,leaving' => 'leaving',
    ];

    public function mount()
    {
        $window = new Window;
        $this->data_test = "";
        $this->qclients = $window->qclients;
        $this->qwindows = $window->qwindows;
        $this->status = "";
        $this->link = "";
        $this->message = "";
        $this->window = [];
        $this->openWindow();
    }

    public function render()
    {
        $this->host = \Auth::user();
        return view('livewire.host-screen');
    }

    public function here()
    {
        // $this->message = 'here';
    }

    public function connect()
    {
        $window = Window::find($this->host->window->id);
        $window->mensaje = 'Connecting';
        $window->save();

        broadcast(new Ring2Event('Connecting'));

        $this->client = $this->host->window->client;
        $data = [
            'user' => $this->host,
            'other' => $this->client,
        ];
        return redirect('/livewire1/video_chat/' . $data['user']->id . '/' . $data['other']->id);
    }

    public function joining()
    {
        $window = new Window;
        $this->qclients = $window->qclients;
        $this->qwindows = $window->qwindows;
    }

    public function leaving($data)
    {
// dd($data);
        $window = new Window;
        $this->qclients = $window->qclients;
        $this->qwindows = $window->qwindows;
    }

    public function ring($data)
    {
        $window = Window::find(\Auth::user()->id);
        $this->window = $window;
        $this->status = $window->status->status;
        $this->message = $window->mensaje;
        $this->link = $window->link;
        $this->qclients = $window->qclients;
        $this->qwindows = $window->qwindows;
    }

    public function openWindow()
    {
        $this->data_test = 'function openWindow';
        $window = $this->window_open();
        $this->window = $window;

        $this->status = $window->status->status;

        $this->message = $this->status;

    }

    public function startWindow()
    {
        $this->data_test = 'function startWindow';
        $response = $this->window_start();
        $this->window = $response;
        $this->status = $response->status->status;
        $this->link = $response->link;
        if(!$response->client_id){
            $this->message = $response->link;
        }else{
            $this->message = "Llamando a " . $response->client->name;
            $this->client = User::find($response->client->id);
        }
    }

    public function free()
    {
        $this->data_test = 'function free';
        $response = $this->window_free();
        $this->window = $response;
        $this->status = $response->status->status;
        $this->link = $response->link;
        $this->message = $this->status;
    }

    public function stopWindow()
    {
        $this->message = 'Desconectando ....';
        $this->data_test = 'function stopWindow';
        $response = $this->window_stop();
        $this->window = $response;
        $this->status = $response->status->status;
        $this->link = $response->link;
        $this->message = $this->status;
    }

    public function pauseWindow()
    {
        $this->data_test = 'function pausepWindow';
        $response = $this->window_paused();
        $this->window = $response;
        $this->status = $response->status->status;
        $this->link = $response->link;
        $this->message = $this->status;
    }

    public function outWindow()
    {
        $this->message = 'Saliendo ....';
        $this->data_test = 'function outWindow';
        $response = $this->window_out();
        $this->window = $response;
        $this->status = $response->status->status;
        $this->link = $response->link;
        $this->message = $this->status;
    }


}


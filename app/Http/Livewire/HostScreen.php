<?php

namespace App\Http\Livewire;

use App\Events\RingEvent;
use App\Http\Traits\WindowTrait;
use Livewire\Component;

class HostScreen extends Component
{

    use WindowTrait;

	public $qcalls;
	public $qwindows;
	public $status;
    public $window;
    public $link;
    public $data_test;

    // Special Syntax: ['echo:{channel},{event}' => '{method}']
    protected $listeners = [
        'echo-private:channel-ring,RingEvent' => 'ring',
        // 'channel-ring' => 'ring',
    ];

    public function mount()
    {
        $this->data_test = "";
        $this->qcalls = 10;
        $this->qwindows = 3;
        $this->status = "";
        $this->link = "";
        if(\Auth::user()->is_host){
            $this->openWindow();
        }
    }

    public function render()
    {
        return view('livewire.host-screen');
    }

    public function openWindow()
    {
        $this->data_test = 'function openWindow';
        $window = $this->window_open();

        // $this->data_test = ['function' => 'openWindow', 'window' => $window];
        $this->status = $window->status->status;

    }

    public function startWindow()
    {
        $this->data_test = 'function startWindow';
        $response = $this->window_start();
        $this->status = $response->status->status;
        $this->link = $response->link;

        session()->flash('message', 'Llamando .... desde startWindow');

        $this->qwindows = $this->qwindows + 1;
    }

    // public function ring($data)
    // {
    //     $this->data_test = 'ring';
    //     $this->status = $data->status;
    //     $this->link = $data->link;
    //     return true;
    //     session()->flash('message', $data->host->name . ' está llamando.' );
    // }

    public function free()
    {
        $this->data_test = 'function free';
        $response = $this->window_free();
        $this->status = $response->status->status;
        $this->link = $response->link;
        session()->flash('message', 'Esta libre.' );
    }

    public function stopWindow()
    {
        $this->data_test = 'function stopWindow';
        $response = $this->window_stop();
        $this->status = $response->status->status;
        $this->link = $response->link;
        $this->qwindows = $this->qwindows - 1;
        session()->flash('message', 'Desconectando ....');
    }

    public function pauseWindow()
    {
        $this->data_test = 'function pausepWindow';
        $response = $this->window_paused();
        $this->status = $response->status->status;
        $this->link = $response->link;
        $this->qwindows = $this->qwindows - 1;
        session()->flash('message', 'En Pausa ....');
    }

    public function outWindow()
    {
        $this->data_test = 'function outWindow';
        $response = $this->window_out();
        $this->status = $response->status->status;
        $this->link = $response->link;
        $this->qwindows = $this->qwindows - 1;
        session()->flash('message', 'Desconectado ....');
    }


}


<?php

namespace App\Http\Livewire;

use App\Http\Traits\WindowTrait;
use Livewire\Component;

class HostScreen extends Component
{

    use WindowTrait;

	public $qcalls;
	public $qwindows;
	public $status;
    public $window;
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
        $window = $this->window_open();

        $this->data_test = $window;

        $this->status = $window->status->status;

    }

    public function startWindow()
    {
        $response = $this->window_start();
        $this->status = $response['status']->status;
        $this->qwindows = $this->qwindows + 1;
        session()->flash('message', 'Llamando ....');
    }

    public function ring($data)
    {
        $response = $this->start();
        $this->status = $data['status'];
        session()->flash('message', $data['host']['name'] . ' está llamando.' );
    }

    public function free()
    {
        $response = $this->window_free();
        $this->status = $response['status']->status;
        session()->flash('message', ' está llamando.' );
    }

    public function stopWindow()
    {
        $response = $this->window_stop();
        $this->status = $response['status']->status;
        $this->qwindows = $this->qwindows - 1;
        session()->flash('message', 'Desconectando ....');
    }

    public function pauseWindow()
    {
        $response = $this->window_paused();
        $this->status = $response['status']->status;
        $this->qwindows = $this->qwindows - 1;
        session()->flash('message', 'En Pausa ....');
    }

    public function outWindow()
    {
        $response = $this->window_out();
        $this->status = $response['status']->status;
        $this->qwindows = $this->qwindows - 1;
        session()->flash('message', 'Desconectado ....');
    }


}


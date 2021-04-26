<?php

namespace App\Http\Livewire;

use App\Events\RingEvent;
use App\Http\Traits\CallTrait;
use App\Http\Traits\WindowTrait;
use App\Models\Status;
use App\Models\Trace;
use App\Models\Window;
use Livewire\Component;

class ClientScreen extends Component
{
    use WindowTrait;
    use CallTrait;

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

    public function ring($data)
    {
// dd($data['host']['name']);
        $response = $this->start();
// dd($response);
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

    public function startWindow()
    {
        $response = $this->window_start();
        $this->status = $response['status']->status;
        $this->qwindows = $this->qwindows + 1;
        session()->flash('message', 'Llamando ....');
    }

    public function outWindow()
    {
        $response = $this->window_out();
        $this->status = $response['status']->status;
        $this->qwindows = $this->qwindows - 1;
        session()->flash('message', 'Desconectado ....');
    }


    public function render()
    {
        return view('livewire.client-screen');
    }

    public function wait()
    {
        $this->status = 'En Pausa';
        $this->qcalls = $this->qcalls + 1;
    	session()->flash('message', 'Poner en cola');
    }

    public function call()
    {
        $this->status = 'Llamando';
        // $this->emit("ring");
        broadcast(new RingEvent(['status'=>'Llamando']));
        session()->flash('message', 'Llamando ....');
    }

    public function connect()
    {
        $this->status = 'Atendiendo';
        $this->qcalls = $this->qcalls - 1;
        $this->qwindows = $this->qwindows + 1;
        session()->flash('message', 'Conectando ....');
    }

    public function disconnect()
    {
        $this->status = 'Cerrado';
        $this->qwindows = $this->qwindows - 1;
    	session()->flash('message', 'Desconectando ....');
    }

    public function openWindow()
    {
        $window = $this->window_open();

        $this->data_test = $window;

        $this->status = $window->status->status;

    }

}

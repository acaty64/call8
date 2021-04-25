<?php

namespace App\Http\Livewire;

use App\Events\RingEvent;
use Livewire\Component;

class ClientScreen extends Component
{
	public $qcalls;
	public $qwindows;
	public $status;

    // Special Syntax: ['echo:{channel},{event}' => '{method}']
    protected $listeners = [
        'echo-private:channel-ring,RingEvent' => 'ring',
        // 'channel-ring' => 'ring',
    ];

    public function mount()
    {
        $this->qcalls = 10;
        $this->qwindows = 3;
        $this->status = "";
    }

    public function ring($data)
    {
// dd($data['host']['name']);
        $this->status = $data['status'];
        session()->flash('message', $data['host']['name'] . ' está llamando.' );
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

}
<?php

namespace App\Http\Livewire;

use App\Events\RingEvent;
use Livewire\Component;

class HostScreen extends Component
{
	public $qcalls;
	public $qwindows;
	public $status;


    public function mount()
    {
        $this->qcalls = 10;
        $this->qwindows = 3;
        $this->status = "";
    }

    public function render()
    {
        return view('livewire.host-screen');
    }

    public function wait()
    {
        $this->status = 'En Pausa';
        $this->qcalls = $this->qcalls + 1;
    	session()->flash('message', 'Poner en cola');
    }

    public function call()
    {
        $data = [
            'status' => 'Llamando'
        ];
        $this->status = 'Llamando';
        broadcast(new RingEvent($data));

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

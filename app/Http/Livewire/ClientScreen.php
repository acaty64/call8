<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ClientScreen extends Component
{
	public $qcalls = 10;
	public $qwindows = 3;
	public $status = "";

    public function render()
    {
        return view('livewire.client-screen');
    }

    public function call()
    {
        $this->status = 'En Pausa';
    	session()->flash('message', 'Poner en cola');
    }

    public function connect()
    {
        $this->status = 'Atendiendo';
        session()->flash('message', 'Conectando ....');
    }

    public function disconnect()
    {
        $this->status = 'Cerrado';
    	session()->flash('message', 'Desconectando ....');
    }


}

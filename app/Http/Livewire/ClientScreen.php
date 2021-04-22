<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ClientScreen extends Component
{
	public $qcalls = 10;
	public $qwindows = 3;
	public $status = "En Pausa";

    public function render()
    {
        return view('livewire.client-screen');
    }

    public function connect()
    {
    	session()->flash('message', 'Conectando ....');
    }

    public function disconnect()
    {
    	session()->flash('message', 'Desconectando ....');
    }


}

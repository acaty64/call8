<?php

namespace App\Http\Livewire;

use App\Events\Test1Event;
use Livewire\Component;

class Test1Screen extends Component
{
	public $mensaje = '';

	protected $listeners = ['echo:channel-test,Test1Event' => 'channelTest',];

    public function render()
    {
        return view('livewire.test1-screen');
    }

    public function send($value='')
    {
    	broadcast(new Test1Event("Este es un mensaje de prueba desde livewire"));
    }

    public function channelTest($data)
    {
		// dd('TestScreen.php', $data);
    	$this->mensaje = $data['message'];
    }

}

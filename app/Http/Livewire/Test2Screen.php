<?php

namespace App\Http\Livewire;

use App\Events\Test2Event;
use Livewire\Component;

class Test2Screen extends Component
{
	public $mensaje = '';

	protected $listeners = ['echo-private:private-channel,Test2Event' => 'channelTest',];

    public function render()
    {
        return view('livewire.test2-screen');
    }

    public function send($value='')
    {
    	broadcast(new Test2Event("Este es un mensaje de prueba desde livewire"));
    }

    public function channelTest($data)
    {
		// dd('Test2Screen.php', $data);
    	$this->mensaje = $data['message'];
    }
}

<?php

namespace App\Http\Livewire\Test;

use App\Events\Test2Event;
use App\Events\Test3Event;
use Livewire\Component;

class Test3Screen extends Component
{

	public $mensaje = '';
	public $users = [];
	public $mensajes = ['Hola1','Hola2'];
	public $here = [];

	// protected $listeners = ['echo-presence:presence-channel,Test3Event' => 'channelTest',];
    protected $listeners = [
        'echo-presence:presence-channel,here' => 'here',
        'echo-presence:presence-channel,joining' => 'joining',
        'echo-presence:presence-channel,leaving' => 'leaving',
        'echo-private:private-channel,Test2Event' => 'channelTest',
    ];
    public function render()
    {
        return view('livewire.test.test3-screen');
    }

    public function send()
    {
    	broadcast(new Test2Event($this->mensaje));
    }

    public function channelTest($data)
    {
		// dd('Test2Screen.php', $data);
    	$this->mensaje = $data['message'];
    	$this->mensajes[] = $this->mensaje;
    }

    public function here($data)
    {
    	$this->here = $data;
    	$this->users = $data;
    	session()->flash('message', 'here function');
    }

    public function joining($data)
    {
    	$this->here[] = $data;
    	session()->flash('message', 'joining function');
    }

    public function leaving($data)
    {
        $here = collect($this->here);

        $firstIndex = $here->search(function ($authData) use ($data) {
            return $authData['id'] == $data['id'];
        });

        $here->splice($firstIndex, 1);

        $this->here = $here->toArray();
    	session()->flash('message', 'leaving function');
    }

    public function incomingMessage($value='')
    {
    	dd('incomingMessage', $value);
    }

    public function listen($value='')
    {
    	dd('listen', $value);
    }

}

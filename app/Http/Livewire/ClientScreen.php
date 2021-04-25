<?php

namespace App\Http\Livewire;

use App\Events\RingEvent;
use App\Models\Status;
use App\Models\Trace;
use App\Models\Window;
use Livewire\Component;

class ClientScreen extends Component
{
	public $qcalls;
	public $qwindows;
	public $status;
    public $window;

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
        if(\Auth::user()->is_host){
            $this->openWindow();
        }

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

    public function openWindow()
    {
        $host_id = \Auth::user()->id;

        $status_id = Status::where('status', 'En Pausa')->first()->id;

        $window = Window::where('host_id', $host_id)->first();
        if(!$window)
        {
            $status_close = Status::where('status', 'Cerrado')->first()->id;
            $window = Window::where('status_id', $status_close)->first();
            $window->host_id = $host_id;
            $window->status_id = $status_id;
            $window->save();
        }
        Trace::new_window($window);

        $this->status = $window->status->status;

        return $window;

    }

}

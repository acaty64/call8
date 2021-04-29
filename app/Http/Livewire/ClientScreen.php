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
    use CallTrait;

	public $message;
    public $qclients;
	public $qwindows;
	public $status;
    public $window;
    public $data_test;
    public $call_id;

    // Special Syntax: ['echo:{channel},{event}' => '{method}']
    protected $listeners = [
        // 'echo:channel-ring,RingEvent' => 'ring',
        'echo-private:channel-ring,Ring2Event' => 'ring',
        // 'channel-ring' => 'ring',
    ];

    public function mount()
    {
        $window = Window::find(1);
        $this->data_test = "";
        $this->qclients = $window->qclients;
        $this->qwindows = $window->qwindows;
        $this->status = "";
        $this->call_id = "";
    }

    public function render()
    {
        return view('livewire.client-screen');
    }

    public function ring($data)
    {
        if($data['status']){
            $this->status = $data['status'];
        }
        $this->message = $data['message'];
        $this->qcalls = $data['qclients'];
        $this->qwindows = $data['qwindows'];

        // session()->flash('message', $data['message']);
        // session()->flash('message', $data['message']);
    }

    public function wait()
    {
        $this->status = 'En Pausa';
        $response = $this->call_open();
        $this->call_id = $response['id'];
        $this->message = 'Está en cola';
    	// session()->flash('message', 'Esta en cola');
    }

    public function connect()
    {
        $this->message = 'Conectando ....';
        $response = $this->answer($this->call_id);
        $this->status = $response['status'];
        // session()->flash('message', 'Conectando ....');
    }

    public function disconnect()
    {
        $this->message = 'Desconectando ....';
        $response = $this->call_close();
        $this->status = 'Cerrado';
    	// session()->flash('message', 'Desconectando ....');
    }

}

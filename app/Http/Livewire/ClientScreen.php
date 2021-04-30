<?php

namespace App\Http\Livewire;

use App\Events\RingEvent;
use App\Http\Traits\CallTrait;
use App\Http\Traits\WindowTrait;
use App\Models\Call;
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
        $this->data_test = "";
        $this->status = "";
        $this->message = "Bienvenido.";
        $this->call_id = null;
        $this->start();
    }

    public function render()
    {
        return view('livewire.client-screen');
    }

    public function start()
    {
        $window = new Window;
        $this->qclients = $window->qclients;
        $this->qwindows = $window->qwindows;
        $call = Call::where('user_id', \Auth::user()->id)->where('status_id', '>', 1)->first();
        if($call){
            $this->call_id = $call->id;
            if($call->window){
                $this->message = $call->window->mensaje;
                $this->status = $call->window->status->status;
            }else{
                $status = Status::find($call->status_id);
                $this->status = $status->status;
                $this->message = $status->status;
            }
        }

    }

    public function ring($data)
    {
        $this->qcalls = $data['qclients'];
        $this->qwindows = $data['qwindows'];

        if($this->call_id > 0){
            $call = Call::find($this->call_id);
            $this->status = $call->status->status;
        }

        if($data['call_id'] == $this->call_id && !is_null($data['call_id'])){
            // $this->message = $data['message'];
            $this->message = $call->window->mensaje;
        }
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
        $this->message = 'Desconectado';
    	// session()->flash('message', 'Desconectando ....');
    }

}

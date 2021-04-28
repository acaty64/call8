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

	public $qcalls;
	public $qwindows;
	public $status;
    public $window;
    public $data_test;

    // Special Syntax: ['echo:{channel},{event}' => '{method}']
    protected $listeners = [
        'echo:channel-ring,RingEvent' => 'ring',
        // 'channel-ring' => 'ring',
    ];

    public function mount()
    {
        $this->data_test = "";
        $this->qcalls = 10;
        $this->qwindows = 3;
        $this->status = "";
    }

    public function render()
    {
        return view('livewire.client-screen');
    }

    public function ring($data)
    {
 // dd('ClientScreen - ring');
        $this->status = $data['status'];
        // session()->flash('message', $data->host->name . ' está llamando.' );
        // $this->data_test = $data;
        session()->flash('message', $data['host'] . ' Está llamando.');
    }

    public function wait()
    {
        $this->status = 'En Pausa';
        $this->qcalls = $this->qcalls + 1;
    	session()->flash('message', 'Esta en cola');
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

<?php

namespace App\Http\Livewire;

use App\Models\Call;
use App\Models\Status;
use App\Models\Window;
use Livewire\Component;

class DashboardScreen extends Component
{
	public $hosts_now;
	public $clients_now;
	public $window_today;
	public $client_today;

    public function render()
    {
        return view('livewire.dashboard-screen');
    }

   	public function mount()
   	{
   		$this->hosts_now = Window::where('host_id', '!=', null)->get();
      $status_paused = Status::where('status', 'En Pausa')->first()->id;
      $this->clients_now = Call::where('status_id',  $status_paused)->get();

   	}




}

<?php

namespace App\Http\Livewire;

use App\Models\Window;
use Livewire\Component;

class DashboardScreen extends Component
{
	public $host_now;
	public $client_now;
	public $window_today;
	public $client_today;

    public function render()
    {
        return view('livewire.dashboard-screen');
    }

   	public function mount()
   	{
   		$host_now = Window::where('host_id', '!=', null)->get();
   		
   	}




}

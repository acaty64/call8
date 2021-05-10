<?php

namespace App\Http\Livewire;

use App\Models\Schedule;
use App\Models\User;
use Livewire\Component;

class ScheduleCrud extends Component
{
	public $schedules;
	public $status;
	public $statuses;

    public function render()
    {
        return view('livewire.schedule-crud');
    }

    public function mount()
    {
    	$this->status = 'create';
    	$this->statuses = ['index', 'create'];
    	$this->schedules = Schedule::all();
    }
}

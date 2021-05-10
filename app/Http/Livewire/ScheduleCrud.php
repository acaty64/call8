<?php

namespace App\Http\Livewire;

use App\Models\Office;
use App\Models\Schedule;
use App\Models\User;
use Livewire\Component;

class ScheduleCrud extends Component
{
    public $message;
	public $schedules;
	public $status;
	public $statuses;
    public $offices;
    public $selectedOffice;

    protected $listeners = ['setStatus'];

    public function render()
    {
        return view('livewire.schedule-crud');
    }

    public function mount()
    {
    	$this->status = 'index';
    	$this->statuses = ['index', 'create'];
    	$this->schedules = Schedule::all();
        $this->offices = Office::all();
        $this->selectedOffice = '';
    }

    public function setStatus($value)
    {
        $this->status = $value;
    }

    public function setMessage($value)
    {
        $this->message = $message;
    }

    public function updated($selectedOffice, $value=[])
    {
        $this->schedules = Schedule::where('office_id', $value)->get();
    }


}

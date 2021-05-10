<?php

namespace App\Http\Livewire;

use App\Http\Traits\ScheduleTrait;
use App\Models\Office;
use App\Models\Schedule;
use App\Models\User;
use Livewire\Component;

class ScheduleCreate extends Component
{
    use ScheduleTrait;

	public $hosts;
	public $offices;
	public $days;
	public $hours;
	public $hours_start;
	public $hours_end;
	public $hour_start;
	public $hour_end;
	public $date_start;
	public $date_end;
    public $selectedHost;
    public $selectedOffice;
    public $selectedDay;

    public function render()
    {
        return view('livewire.schedule-create');
    }

    public function mount()
    {
    	$this->hosts = User::where('id', '<', 4)->get();
        $this->selectedHost = '';
    	$this->offices = Office::all();
        $this->selectedOffice = '';
    	$this->days = [
    		'0' => 'Domingo',
    		'1' => 'Lunes',
    		'2' => 'Martes',
    		'3' => 'Miércoles',
    		'4' => 'Jueves',
    		'5' => 'Viernes',
    		'6' => 'Sábado',
    	];
        $this->selectedDay = '';
        $this->hours_start = $this->hours();
        $this->hour_start = '';
        $this->hours_end = $this->hours();
        $this->hour_end = '';
    }

    public function save()
    {
        Schedule::create([
            'host_id' => $this->selectedHost,
            'office_id' => $this->selectedOffice,
            'day' => $this->selectedDay,
            'hour_start' => $this->hour_start,
            'hour_end' => $this->hour_end,
            'date_start' => $this->date_start,
            'date_end' => $this->date_end,
        ]);
    }



}

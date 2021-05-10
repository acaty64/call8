<?php

namespace App\Http\Livewire;

use App\Http\Traits\ScheduleTrait;
use App\Models\Office;
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
	public $hours_stop;
	public $hour_start;
	public $hour_stop;
	public $date_start;
	public $date_stop;
    public $selectedOffice;
    public $selectedDay;

    public function render()
    {
        return view('livewire.schedule-create');
    }

    public function mount()
    {
    	$this->hosts = User::where('id', '<', 4)->get();
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
        $this->hours_stop = $this->hours();
        $this->hour_stop = '';
    	// $hours = [];
    	// for ($h=0; $h < 21; $h++) {
    	// 	for ($m=0; $m < 2; $m++) { 
    	// 	 	# code...
    	// 	 } 
    	// 	# code...
    	// }
    }



}

<?php

namespace App\Http\Livewire;

use App\Http\Traits\ScheduleTrait;
use App\Models\Schedule;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Livewire\Component;

class ScheduleScreen extends Component
{
	public $hosts;
	public $inicio;
	public $fin;
    public $schedule;

    use ScheduleTrait;

    public function render()
    {
        return view('livewire.schedule-screen');
    }

    public function mount()
    {
    	$this->hosts = User::where('id','<', 4)->get();
    	$now = new Carbon();

    	$this->inicio = $now->format('Y-m-d');
    	$this->fin = $now->addDays(7)->format('Y-m-d');
        $this->getSchedule();
    }

    public function getSchedule()
    {
    	$inicio_old = CarbonImmutable::create($this->inicio);
    	$dow = $inicio_old->dayOfWeek;
    	if($dow == 0){
    		$inicio_new = $inicio_old->addDay();
    	}else{
    		$inicio_new = $inicio_old->subDays($dow - 1);
    	}

        $this->inicio = $inicio_new->format('Y-m-d');
    	$this->fin = $inicio_new->addDays(6)->format('Y-m-d');

        $users = $this->hosts;
        $schedule = [];
        foreach ($users as $user){

        	$horario = $this->horario($user->id, $this->inicio);

	        foreach ($horario as $k => $v) {
	        	if(empty($schedule[$k])){
		        	foreach ($v as $k2=> $v2) {
		        		$schedule[$k][$k2] = $v2;
		        	}
	        	}else{
		        	foreach ($v as $k2 => $v2) {
						foreach ($v2 as $k3 => $v3) {
			        		if(is_numeric($schedule[$k][$k2][$k3])){
				        		$schedule[$k][$k2][$k3] = $schedule[$k][$k2][$k3]+$v3;
			        		}
						}
		        	}
	        	}
	        }
        }

        $this->schedule = $schedule;
    }

    public function updated($inicio, $value)
    {
		$this->inicio = $value;
		$dia = new CarbonImmutable($this->inicio);
    	$this->fin = $dia->addDays(6)->format('Y-m-d');
        $this->getSchedule();
    }


}

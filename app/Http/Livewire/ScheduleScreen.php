<?php

namespace App\Http\Livewire;

use App\Http\Traits\ScheduleTrait;
use App\Models\Office;
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
    public $offices;
    public $selectedOffice;

    use ScheduleTrait;

    public function render()
    {
        return view('livewire.schedule-screen');
    }

    public function mount()
    {
    	$this->hosts = [];
    	$now = new Carbon();

    	$this->inicio = $now->format('Y-m-d');
    	$this->fin = $now->addDays(7)->format('Y-m-d');
        $this->offices = Office::all();
        $this->selectedOffice = 1;
        $this->getSchedule();
    }

    public function getSchedule()
    {
    	$inicio_old = CarbonImmutable::create($this->inicio);
    	$dow = $inicio_old->dayOfWeek;
        $inicio_new = $inicio_old->subDays($dow);

        $this->inicio = $inicio_new->format('Y-m-d');
    	$this->fin = $inicio_new->addDays(6)->format('Y-m-d');

        $users = Schedule::where('office_id', $this->selectedOffice)
                    ->where('date_start', '<=', $this->inicio)
                    ->where('date_end', '>=', $this->fin)
                    ->pluck('host_id')->unique();

        $this->hosts = User::whereIn('id', $users)->get();

        $schedule = [];
        foreach ($users as $user){

        	$horario = $this->horario($this->inicio, $user, $this->selectedOffice);

	        foreach ($horario as $k => $v) {
	        	if(empty($schedule[$k])){
		        	foreach ($v as $k2=> $v2) {
		        		$schedule[$k][$k2] = $v2;
		        	}
	        	}else{
		        	foreach ($v as $k2 => $v2) {
		        		if(is_numeric($schedule[$k][$k2])){
			        		$schedule[$k][$k2] = $schedule[$k][$k2] + $v2;
		        		}
		        	}
	        	}
	        }
        }

        $screen = [];
        foreach ($schedule as $key => $value) {
            $screen[$key] = [];
            foreach ($value as $key2 => $value2) {
                if($key2 == 0){
                    $screen[$key][] = [
                        'class' => 'col-sm-2',
                        'value' => $value2,
                    ];
                }else{
                    $screen[$key][] = [
                        'class' => 'col-sm-1',
                        'value' => $value2,
                    ];
                }
            }
        }

        $this->schedule = $screen;
    }

    public function updated($field, $value)
    {
        if($field == 'inicio')
        {
            $this->inicio = $value;
            $dia = new CarbonImmutable($this->inicio);
            $this->fin = $dia->addDays(6)->format('Y-m-d');
            $this->getSchedule();
        }
        if($field == 'selectedOffice')
        {
            $this->getSchedule();
        }
    }


}

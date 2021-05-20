<?php

namespace App\Http\Livewire;

use App\Http\Traits\ScheduleTrait;
use App\Models\Office;
use App\Models\Schedule;
use App\Models\User;
use Carbon\CarbonImmutable;
use Livewire\Component;

class ScheduleEdit extends Component
{
    use ScheduleTrait;

    public $schedule_id;
    public $errores;
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
    public $min_date_start;
    public $min_date_end;
    public $host_name;
    public $selectedOffice;
    public $selectedDay;
    public $host_id;
    public $office_id;
    public $day;

    protected $rules = [
            'host_id' => 'required',
            'selectedOffice' => 'required',
            'selectedDay' => 'required',
            'hour_start' => 'required',
            'hour_end' => 'required',
            'date_start' => 'required',
            'date_end' => 'required',
    ];


    public function render()
    {
        return view('livewire.schedule-edit');
    }

    public function mount()
    {
        $this->errores = [];
        $this->schedule = Schedule::find($this->schedule_id);
        $this->host_name = $this->schedule->host->name;
        $this->host_id = $this->schedule->host_id;
    	$this->offices = Office::all();
        $this->selectedOffice = $this->schedule->office_id;
        $this->office_id = $this->selectedOffice;
    	$this->days = [
    		'0' => 'Domingo',
    		'1' => 'Lunes',
    		'2' => 'Martes',
    		'3' => 'Miércoles',
    		'4' => 'Jueves',
    		'5' => 'Viernes',
    		'6' => 'Sábado',
    	];
        $this->day = $this->schedule->day;
        $this->selectedDay = $this->day;
        $this->hours_start = $this->hours();
        $this->hour_start = $this->schedule->hour_start;
        $this->hours_end = $this->hours();
        $this->hour_end = $this->schedule->hour_end;
        $this->date_start = $this->schedule->date_start;
        $this->date_end = $this->schedule->date_end;
        $this->min_date_start = CarbonImmutable::now()->format('Y-m-d');
        $this->min_date_end = $this->date_start;
    }

    public function save()
    {
        $this->validate();
        $data = [
            'host_id' => $this->host_id,
            'office_id' => $this->selectedOffice,
            'day' => $this->selectedDay,
            'hour_start' => $this->hour_start,
            'hour_end' => $this->hour_end,
            'date_start' => $this->date_start,
            'date_end' => $this->date_end,
        ];

        $schedule = Schedule::find($this->schedule_id);

        $response = $this->checkScheduleEdit($schedule);

        if($response == []){
            $schedule->office_id = $this->selectedOffice;
            $schedule->day = $this->selectedDay;
            $schedule->hour_start = $this->hour_start;
            $schedule->hour_end = $this->hour_end;
            $schedule->date_start = $this->date_start;
            $schedule->date_end = $this->date_end;
            $schedule->save();
            $this->errors = [];
            // session()->flash('message', 'Registro grabado.');
            $this->emit('setStatus', 'index');
        }
        $this->errores = $response;
        session()->flash('message', 'Error, revise las fechas y horas.');
    }


    public function updated($field, $value)
    {
        $this->errores = [];
        if($field == 'hour_start'){
            $new = [];
            foreach ($this->hours() as $key => $val) {
                if($val > $value){
                    $new[] = $val;
                }
            }
            $this->hours_end = $new;
        }
        if($field == 'date_start'){
            $this->date_end = $value;
            $this->min_date_end = $value;
        }
    }

}

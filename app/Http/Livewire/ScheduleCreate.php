<?php

namespace App\Http\Livewire;

use App\Http\Traits\ScheduleTrait;
use App\Models\Office;
use App\Models\Schedule;
use App\Models\User;
use Carbon\CarbonImmutable;
use Livewire\Component;

class ScheduleCreate extends Component
{
    use ScheduleTrait;

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
    public $selectedHost;
    public $selectedOffice;
    public $selectedDay;
    public $host_id;
    public $office_id;
    public $day;

    // protected $listeners = ['newHost'];


    protected $rules = [
            'selectedHost' => 'required',
            'selectedOffice' => 'required',
            'selectedDay' => 'required',
            'hour_start' => 'required',
            'hour_end' => 'required',
            'date_start' => 'required',
            'date_end' => 'required',
    ];


    public function render()
    {
        return view('livewire.schedule-create');
    }

    public function mount()
    {
        $this->errores = [];
        // $this->hosts = User::where('id', '<', 4)->get();
        $this->hosts = User::all()->filter(function($model){
                return $model->is_host == true;
            });
        $this->selectedHost = '';
        $this->host_id = null;
    	$this->offices = Office::all();
        $this->selectedOffice = '';
        $this->office_id = null;
    	$this->days = [
    		'0' => 'Domingo',
    		'1' => 'Lunes',
    		'2' => 'Martes',
    		'3' => 'Miércoles',
    		'4' => 'Jueves',
    		'5' => 'Viernes',
    		'6' => 'Sábado',
    	];
        $this->day = null;
        $this->selectedDay = '';
        $this->hours_start = $this->hours();
        $this->hour_start = $this->hours_start[0];
        $this->hours_end = $this->_hours_end();
        $this->hour_end = $this->hours_end[0];
        $this->date_start = CarbonImmutable::now()->format('Y-m-d');
        $this->date_end = CarbonImmutable::now()->format('Y-m-d');
        $this->min_date_start = CarbonImmutable::now()->format('Y-m-d');
        $this->min_date_end = CarbonImmutable::now()->format('Y-m-d');

    }

    public function _hours_end(){
        $hours = $this->hours();

        $new = [];

        foreach($hours as $key => $hour){
            if($hour >= $this->hour_start){
                $h = substr($hour, 0, 2);
                $m = substr($hour, 3, 2);
                $new[] = str_pad($h, 2, "00", STR_PAD_LEFT)  . ":" . str_pad($m + 29, 2, "00", STR_PAD_LEFT);;
            }
        }

        return $new;
    }

    public function save()
    {
        $this->validate();
        $data = [
            'host_id' => $this->selectedHost,
            'office_id' => $this->selectedOffice,
            'day' => $this->selectedDay,
            'hour_start' => $this->hour_start,
            'hour_end' => $this->hour_end,
            'date_start' => $this->date_start,
            'date_end' => $this->date_end,
        ];

        $schedule = new Schedule($data);

        $response = $this->checkSchedule($schedule);

        if($response == []){
            Schedule::create($data);
            $this->errores = null;
            session()->flash('message', 'Registro grabado.');

            $this->emit('setStatus', 'index');
        }
        $this->errores = $response;
        session()->flash('message', 'Error, revise las fechas y horas.');
    }

    public function updated($field, $value)
    {
        $this->errores = [];
        if($field == 'selectedHost'){
            $this->host_id = $value;
        }
        if($field == 'hour_start'){
            $this->hours_end = $this->_hours_end();
        }
        if($field == 'date_start'){
            $this->date_end = $value;
            $this->min_date_end = $value;
        }
    }

}

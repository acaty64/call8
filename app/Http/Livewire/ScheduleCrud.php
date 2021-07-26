<?php

namespace App\Http\Livewire;

use App\Exports\SchedulesExport;
use App\Models\Office;
use App\Models\Schedule;
use App\Models\User;
use Carbon\CarbonImmutable;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class ScheduleCrud extends Component
{
    public $message;
	public $schedules;
	public $status;
	public $statuses;
    public $offices;
    public $hosts;
    public $days;
    public $selectedOffice;
    public $selectedHost;
    public $selectedDay;
    public $schedule_id;

    protected $listeners = ['setStatus'];

    public function render()
    {
        return view('livewire.schedule-crud');
    }

    public function mount()
    {
    	$this->status = 'index';
    	$this->statuses = ['index', 'create'];
        $this->selectedOffice = '';
        $this->getData();
    }

    public function getData()
    {
    	$this->schedules = Schedule::all();
        $this->offices = Office::all();

        $host_array = $this->schedules->pluck('host_id')->toArray();

        $array_values = array_unique(array_values($host_array));

        $this->hosts = User::whereIn('id', array_values($array_values))->get();

        $this->days = [
            '0' => 'Domingo',
            '1' => 'Lunes',
            '2' => 'Martes',
            '3' => 'Miércoles',
            '4' => 'Jueves',
            '5' => 'Viernes',
            '6' => 'Sábado',
        ];


        $this->schedules->pluck('day')->unique();
    }


    public function setStatus($value)
    {
        $this->status = $value;
    }

    public function setMessage($value)
    {
        $this->message = $message;
    }

    public function updated($selected, $value='')
    {
        $arrayFilter = [];
        switch ($selected) {
            case 'selectedOffice':
                $field = 'office_id';
                break;
            case 'selectedHost':
                $field = 'host_id';
                break;
            case 'selectedDay':
                $field = 'day';
                break;
            case 'status';
                return true;
                break;
        }
        if(!$value == '')
        {
            $arrayFilter[] = [
                $field, $value
            ];
        }else{
            foreach ($arrayFilter as $key => $value) {
                if($value == [$field, $value])
                {
                    unset($arrayFilter[$key]);
                }
            }
        }
        $this->schedules = Schedule::where($arrayFilter)->get();
    }

    public function edit($schedule_id)
    {
        $this->schedule_id = $schedule_id;
        $this->status = 'edit';
    }

    public function destroy($schedule_id)
    {
        $schedule = Schedule::find($schedule_id);
        $schedule->delete();
        $this->schedules = Schedule::all();
        session()->flash('message', 'Registro ' . $schedule_id . ' eliminado.');
    }


    public function export()
    {
        // $rowSelect = $this->schedules->filter(function($p) => $p)->keys();
        $rowSelect = $this->schedules->select('id');

        $now = CarbonImmutable::now()->format('Y_m_d_H_i_s');
        $file_out =  'Schedules_' . $now . '.xlsx';

        return Excel::download(new SchedulesExport($rowSelect), $file_out);

    }

}

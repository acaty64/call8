<?php

namespace App\Http\Traits;

use App\Events\Ring2Event;
use App\Models\Call;
use App\Models\Schedule;
use App\Models\Status;
use App\Models\Trace;
use App\Models\User;
use App\Models\Window;
use Carbon\Carbon;
use Carbon\CarbonImmutable;

trait ScheduleTrait
{

    public function horario($host_id, $inicio)
    {
        $hours = $this->hours();
        $y = 0;
        $horas = [];
        foreach ($hours as $kh => $vh) {
            $horas[$y++][] = $vh;
        }

        foreach ($horas as $key => $value) {
            $h1 = $value[0];
            $m = substr($h1, 3,2) + 29;
            $h2 = str_pad(substr($h1,0,2), 2, "00", STR_PAD_LEFT) . ":" . $m ;
            $items = Schedule::where('host_id', $host_id)
                ->where('hour_start','<=', $h1)
                ->where('hour_end','>=', $h2)
                ->whereDate('date_start', '<=', $inicio)
                ->whereDate('date_end', '>=', $inicio)
                ->get();

            foreach ($items as $key1 => $value1) {
                if($value1->day == 0){
                    $horas[$key][7] = 1;
                }else{
                    $horas[$key][$value1->day] = 1;
                }
            }
        }
        $horario = [];
        foreach ($horas as $key2 => $value2) {
            $item = [];
            $y = [];
            for($n = 0; $n < 8; $n++){
                if($n == 0){
                    $item['class'] = 'col-sm-2';
                }else{
                    $item['class'] = 'col-sm-1';
                }
                if(empty($value2[$n])){
                    $item['value'] = '0';
                }else{
                    $item['value'] = $value2[$n];
                }
                $y[] = $item;
            }
            $horario[] = $y;
        }
        return $horario;
    }

    public function hours()
    {
        $horas = [];
        $y = 0;
        for ($h=8; $h < 21; $h++) {
            for ($m=0; $m < 2; $m++) {
                $horas[] = str_pad($h, 2, "00", STR_PAD_LEFT)  . ":" . str_pad($m * 30, 2, "00", STR_PAD_LEFT);
            }
        }
        return $horas;
    }

    public function checkSchedule(Schedule $data)
    {
        $schedules = Schedule::where('host_id', $data->host_id)
                    ->where('office_id', '<=', $data->office_id)
                    ->where('day', '<=', $data->day)
                    ->get();

        $error = [];
        foreach ($schedules as $value) {
            if(($data->date_start <= $value->date_start && 
                    $data->date_end >= $value->date_start) || 
                        ($data->date_start >= $value->date_start && 
                        $data->date_start <= $value->date_end)){
                if(($data->hour_start <= $value->hour_start && 
                    $data->hour_end >= $value->hour_start) || 
                        ($data->hour_start >= $value->hour_start && 
                        $data->hour_start <= $value->hour_end)){
                    $error[] = $value;
                }
            }
        }

        return $error;
    }

}

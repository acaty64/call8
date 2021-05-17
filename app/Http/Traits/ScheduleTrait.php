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

    public function horario($inicio, $host_id=null, $office_id=null)
    {
        $inicio = CarbonImmutable::create($inicio);

        $f_ini = $inicio->subdays($inicio->dayOfWeek);
        $f_fin = $f_ini->addDays(6);

        $days = [];
        for ($i=0; $i < 7; $i++) {
            $f = $f_ini->addDays($i);
            $days[] = $f;
        }

        $hours = $this->hours();
        $y = 0;
        $horas = [];
        foreach ($hours as $kh => $vh) {
            $horas[$y][0] = $vh;
            for ($i=0; $i < 7; $i++) {
                $horas[$y][$i+1] = 0;
            }
            $y++;
        }
        foreach ($days as $day) {
            foreach ($hours as $value) {
                $schedules = $this->scheduleFilter($day->format('Y-m-d'), $value, $host_id, $office_id);
                foreach ($schedules as $schedule) {
                    if( $day->dayOfWeek == $schedule->day )
                    {
                        $indice = array_search($value, $hours);
                        $horas[$indice][$day->dayOfWeek + 1]++;
                    }
                }
            }
        }
        return $horas;

    }

    public function scheduleFilter($fecha, $hora, $host_id=null, $office_id=null)
    {
        $h1 = $hora;
        $m = substr($h1, 3,2) + 29;
        $h2 = str_pad(substr($h1,0,2), 2, "00", STR_PAD_LEFT) . ":" . $m ;
        if(is_null($host_id))
        {
            $items = Schedule::where('office_id', $office_id)
                    ->where('hour_start','<=', $h1)
                    ->where('hour_end','>=', $h2)
                    ->whereDate('date_start', '<=', $fecha)
                    ->whereDate('date_end', '>=', $fecha)
                    ->get();
        }else{
            if(is_null($office_id))
            {
                $items = Schedule::where('host_id', $host_id)
                    ->where('hour_start','<=', $h1)
                    ->where('hour_end','>=', $h2)
                    ->whereDate('date_start', '<=', $fecha)
                    ->whereDate('date_end', '>=', $fecha)
                    ->get();
            }else{
                $items = Schedule::where('host_id', $host_id)
                    ->where('office_id', $office_id)
                    ->where('hour_start','<=', $h1)
                    ->where('hour_end','>=', $h2)
                    ->whereDate('date_start', '<=', $fecha)
                    ->whereDate('date_end', '>=', $fecha)
                    ->get();
            }
        }

        return $items;

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
                        $data->date_start <= $value->date_end))
            {
                if(($data->hour_start <= $value->hour_start && 
                    $data->hour_end >= $value->hour_start) || 
                        ($data->hour_start >= $value->hour_start && 
                        $data->hour_start <= $value->hour_end))
                {
                    if($data->day == $value->day)
                    {
                        $error[] = $value;
                    }                }
            }
        }

        return $error;
    }

    public function horary($office_id)
    {
        $now = Carbon::now()->format('Y-m-d');
        $today = Carbon::now()->dayOfWeek;
        $hosts = Schedule::where('office_id', $office_id)
                        ->where('date_start', '<=', $now)
                        ->where('date_end', '>=', $now)
                        ->where('day', $today)
                        ->groupBy('host_id')
                        ->pluck('host_id');

        $horas = $this->hours();
        $schedule = [];
        foreach ($hosts as $key => $host_id) {
            $horario = $this->horario($now, $host_id, $office_id);
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

        $col_today = $today + 1;
        $horary = [];
        $horary[0]['ini'] = '';
        $horary[0]['fin'] = '';
        $n = 0;
        $ini = false;
        foreach ($schedule as $key => $value) {
            if($value[$col_today] > 0)
            {
                if($horary[$n]['ini'] == '')
                {
                    $horary[$n]['ini'] = $schedule[$key][0];
                    $horary[$n]['fin'] = '';
                }else{
                    if($schedule[$key-1][$col_today] == 1)
                    {
                        $h = substr($schedule[$key][0],0,2);
                        $m = substr($schedule[$key][0],3,2) + 29;
                        $fin = str_pad($h, 2, "00", STR_PAD_LEFT)  . ":" . str_pad($m, 2, "00", STR_PAD_LEFT);
                        $horary[$n]['fin'] = $fin;
                    }else{
                        $n++;
                        $horary[$n]['ini'] = $schedule[$key][0];
                        $horary[$n]['fin'] = '';
                    }
                }
            }
        }
        if($horary[0]['ini'] == '')
        {
            return null;
        }

        return $horary;

    }

    public function horary_office($office_id, $today)
    {
        $now = Carbon::now()->format('Y-m-d');
        $hosts = Schedule::where('office_id', $office_id)
                        ->where('date_end', '>=', $now)
                        ->where('day', $today)
                        ->groupBy('host_id')
                        ->pluck('host_id');

        $horas = $this->hours();

        $schedule = [];
        foreach ($hosts as $key => $host_id) {
            $horario = $this->horario($now, $host_id, $office_id);
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
        $horary = [];
        $horary[0]['ini'] = '';
        $horary[0]['fin'] = '';
        $n = 0;
        $ini = false;
        foreach ($schedule as $key => $value) {
            if($value[$today] > 0)
            {
                if($horary[$n]['ini'] == '')
                {
                    $horary[$n]['ini'] = $schedule[$key][0];
                    $horary[$n]['fin'] = '';
                }else{
                    if($schedule[$key-1][$today] == 1)
                    {
                        $h = substr($schedule[$key][0],0,2);
                        $m = substr($schedule[$key][0],3,2) + 29;
                        $fin = str_pad($h, 2, "00", STR_PAD_LEFT)  . ":" . str_pad($m, 2, "00", STR_PAD_LEFT);
                        $horary[$n]['fin'] = $fin;
                    }else{
                        $n++;
                        $horary[$n]['ini'] = $schedule[$key][0];
                        $horary[$n]['fin'] = '';
                    }
                }
            }
        }
        if($horary[0]['ini'] == '')
        {
            return null;
        }

        return $horary;

    }

}

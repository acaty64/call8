<?php

namespace App\Http\Controllers;

use App\Models\Call;
use App\Models\Office;
use App\Models\Trace;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{

    public function test()
    {
        $calls = Call::all();
        $nreg = 0;
        $total_time = 0;
        foreach ($calls as $call) {
            $trace = new Trace;
            $call_time = $trace->attend_time($call->id);
            if($call_time){
                $nreg ++ ;
                $total_time = $total_time + $call_time;
            };
        }
        dd('test', $total_time, $nreg);

    }

    public function average($report)
    {
        if($report == 'atendido')
        {
            $title = 'Promedio de tiempo de llamadas atendidas';
        }elseif ($report == "esperando") {
            $title = 'Promedio de tiempo de espera';
        }
        $averages = [];
        $calls = Call::all();
        $offices = $calls->pluck('office_id')->unique();
        foreach($offices as $office_id)
        {
            $office = Office::findOrFail($office_id);
            $dates = Call::selectRaw("substr(created_at,1,10) as date")
                        ->where('office_id', $office_id)
                         ->distinct('date')
                         ->pluck('date')
                         ->toArray();
            foreach($dates as $date)
            {
                $data = Call::whereDate('created_at', $date)
                        ->where('office_id', $office_id)
                        ->get();
                $nreg = 0;
                $time = 0;

                foreach($data as $item)
                {
                    $trace = new Trace;
                    if($report == 'atendido')
                    {
                        $call_time = $trace->attend_time($item->id);
                    } elseif ($report == "esperando") {
                        $call_time = $trace->paused_time($item->id);
                    }
                    if($call_time)
                    {
                        $nreg = $nreg + 1 ;
                        $time = $time + $call_time;
                    }
                }
                $averages[] = [
                    'office_id' => $office->name,
                    'date' => $date,
                    'average' => ($nreg == 0) ? 0 :$time/$nreg,
                ];
            }
        }
        return view('app.report.average', [
            'title' => $title,
            'data' => $averages,
        ]);

    }

}

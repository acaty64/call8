<?php

namespace App\Http\Traits;

use App\Models\Schedule;
use App\Models\Trace;
use Carbon\Carbon;
use Carbon\CarbonImmutable;

trait ReportScheduleTrait
{
	public function ScheduleDateRange($date_start, $date_end)
	{
		$array_where = [
			['date_start', '<=', $date_start],
			['date_end', '>=', $date_end],
		];
		$schedules = Schedule::where($array_where)
			->get();

		return $schedules;

	}

    public function ScheduleForHost($date_start, $date_end, $host_id=null)
    {
    	$schedules = $this->ScheduleDateRange($date_start, $date_end);

    	if(is_null($host_id)){
	    	return $schedules->sortBy(['host_id', 'date_start', 'office_id', 'day']);
    	}
    	return $schedules->where('host_id', $host_id)
    				->sortBy(['host_id', 'date_start', 'office_id', 'day']);

    }

    public function ScheduleForOffice($date_start, $date_end, $office_id=null)
    {
    	$schedules = $this->ScheduleDateRange($date_start, $date_end);

    	if(is_null($office_id)){
	    	return $schedules->sortBy(['office_id', 'host_id', 'date_start', 'day']);
    	}
	    return $schedules->where('office_id', $office_id)
	    			->sortBy(['office_id', 'host_id', 'date_start', 'day']);
    }




}
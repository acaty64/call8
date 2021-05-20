<?php

namespace App\Http\Traits;

use App\Models\Schedule;

trait ReportTrait
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


}
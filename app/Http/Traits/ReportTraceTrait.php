<?php

namespace App\Http\Traits;

use App\Models\Schedule;
use App\Models\Trace;
use Carbon\Carbon;
use Carbon\CarbonImmutable;

trait ReportTraceTrait
{

	public function TraceDateRange($date_start, $date_end)
	{
		$fecha_start = CarbonImmutable::create($date_start);
		$fecha_end = CarbonImmutable::create($date_end);

		$array_where = [
			['created_at', '>=', $fecha_start],
			['created_at', '<=', $fecha_end],
		];
		$traces = Trace::where($array_where)
			->get();

		return $traces;
	}

	public function StatisticHosts($date_start, $date_end)
	{
		$traces = $this->TraceDateRange($date_start, $date_end);

		$fecha_start = CarbonImmutable::create($date_start);
		$fecha_end = CarbonImmutable::create($date_end);

		$fechas = [];
		for ($i=0; $i < $fecha_start->diffInDays($fecha_end) + 1; $i++) {
			$fechas[] = $fecha_start->addDays($i)->format('Y-m-d');
		}

		$data = [];
		foreach ($fechas as $fecha) {
				$data[$fecha] = [];
				$offices = $traces->where('date', $fecha)
								->where('host_id', '!=', null)
								->pluck('office_id')
								->unique();
			foreach ($offices as $office_id) {
				$data[$fecha][$office_id] = [];
				$hosts = $traces->where('date', $fecha)
									->where('host_id', '!=', null)
									->where('office_id', $office_id)
									->pluck('host_id')->unique();
				foreach ($hosts as $host_id) {
					$data[$fecha][$office_id][$host_id] = [];
					$calls = $traces->where('date', $fecha)
										->where('host_id', '!=', null)
										->where('office_id', $office_id)
										->where('host_id', $host_id)
										->pluck('call_id')->unique();
					foreach ($calls as $call_id) {
						$call_id = is_null($call_id) ? 0 : $call_id;
						$data[$fecha][$office_id][$host_id][$call_id] = [];
						$items = $traces->where('date', $fecha)
											->where('host_id', '!=', null)
											->where('office_id', $office_id)
											->where('host_id', $host_id)
											->where('call_id', $call_id);
						foreach($items as $item){
							// dd(array_key_exists($host_id, $data[$fecha]));
							switch ($item->status_id) {
								case 1:
									$data[$fecha][$office_id][$host_id][$call_id]['host_end'] = $item->created_at->format('H:i:s');
									break;
								case 2:
									if(!array_key_exists('host_start', $data[$fecha][$office_id][$host_id][$call_id])){
										$data[$fecha][$office_id][$host_id][$call_id]['host_start'] = $item->created_at->format('H:i:s');
									}
									$data[$fecha][$office_id][$host_id][$call_id]['pause_end'] = $item->created_at->format('H:i:s');
									break;
								case 3:
									$data[$fecha][$office_id][$host_id][$call_id]['call_start'] = $item->created_at->format('H:i:s');
									break;
								case 4:
									$data[$fecha][$office_id][$host_id][$call_id]['call_end'] = $item->created_at->format('H:i:s');
									$data[$fecha][$office_id][$host_id][$call_id]['attention_init'] = $item->created_at->format('H:i:s');
									break;
								case 5:
									if(array_key_exists('attention_init', $data[$fecha][$office_id][$host_id][$call_id])){
										$data[$fecha][$office_id][$host_id][$call_id]['attention_end'] = $item->created_at->format('H:i:s');
									}
									$data[$fecha][$office_id][$host_id][$call_id]['pause_start'] = $item->created_at->format('H:i:s');
									break;
							}
						}
					}
				}
			}
		}

		return $data;

	}

	public function StatisticClients($date_start, $date_end)
	{
		$traces = $this->TraceDateRange($date_start, $date_end);

		$fecha_start = CarbonImmutable::create($date_start);
		$fecha_end = CarbonImmutable::create($date_end);

		$fechas = [];
		for ($i=0; $i < $fecha_start->diffInDays($fecha_end) + 1; $i++) {
			$fechas[] = $fecha_start->addDays($i)->format('Y-m-d');
		}

		$data = [];
		foreach ($fechas as $fecha) {
			$data[$fecha] = [];
			$offices = $traces->where('date', $fecha)
								->where('client_id', '!=', null)
								->pluck('office_id')
								->unique();
			foreach ($offices as $office_id) {
				$data[$fecha][$office_id] = [];
				$clients = $traces->where('date', $fecha)
									->where('client_id', '!=', null)
									->where('office_id', $office_id)
									->pluck('client_id')
									->unique();
				foreach ($clients as $client_id) {
					$data[$fecha][$office_id][$client_id] = [];
					$calls = $traces->where('date', $fecha)
										->where('client_id', '!=', null)
										->where('office_id', $office_id)
										->where('client_id', $client_id)
										->pluck('call_id')->unique();
					foreach ($calls as $call_id) {
						$data[$fecha][$office_id][$client_id][$call_id] = [];
						$items = $traces->where('date', $fecha)
											->where('client_id', '!=', null)
											->where('office_id', $office_id)
											->where('client_id', $client_id)
											->where('call_id', $call_id);
						foreach($items as $item){
							switch ($item->status_id) {
								case 1:
									$data[$fecha][$office_id][$client_id][$call_id]['call_end'] = $item->created_at->format('H:i:s');
									$data[$fecha][$office_id][$client_id][$call_id]['attention_end'] = $item->created_at->format('H:i:s');
									break;
								case 3:
									$data[$fecha][$office_id][$client_id][$call_id]['pause_end'] = $item->created_at->format('H:i:s');
									$data[$fecha][$office_id][$client_id][$call_id]['call_start'] = $item->created_at->format('H:i:s');
									break;
								case 4:
									$data[$fecha][$office_id][$client_id][$call_id]['call_end'] = $item->created_at->format('H:i:s');
									$data[$fecha][$office_id][$client_id][$call_id]['attention_start'] = $item->created_at->format('H:i:s');
									break;
								case 5:
									$data[$fecha][$office_id][$client_id][$call_id]['pause_start'] = $item->created_at->format('H:i:s');
									break;
							}
						}
					}
				}
			}
		}

		return $data;

	}

	public function HostTimeAverage($date_start, $date_end)
	{
		$data = $this->StatisticHosts($date_start, $date_end);
		$nHosts = 0;
		$date_0 = CarbonImmutable::createFromTime(0, 0, 0, 'America/Lima');
		$date_1 = CarbonImmutable::createFromTime(0, 0, 0, 'America/Lima');
		foreach ($data as $key => $fecha) {
			if( !$fecha == [] ){
				foreach ($fecha as $key => $office) {
					foreach ($office as $key => $host) {
						foreach ($host as $key => $call) {
							if ( $key == 0 ){
								$nHosts++;
								$start = Carbon::parse($call['host_start']);
								if(!array_key_exists('host_end', $call)){
									$end = Carbon::now();
								}else{
									$end = Carbon::parse($call['host_end']);
								}
								$h = $end->diff($start)->format('%H');
								$m = $end->diff($start)->format('%i');
								$s = $end->diff($start)->format('%s');
								$date_1 = $date_1->addHours($h)->addMinutes($m)->addSeconds($s);
							}
						}
					}
				}
			}
		}
		$h = $date_1->format('H')*60*60;
		$m = $date_1->format('i')*60;
		$s = $date_1->format('s');

		$average = ($h + $m + $s) / $nHosts;
		$cAverage = Carbon::parse($average)->format("H:i:s");

		return $cAverage;

	}

	public function HostAttentionAverage($date_start, $date_end)
	{
		$data = $this->StatisticHosts($date_start, $date_end);

		$nHosts = 0;
		$date_0 = CarbonImmutable::createFromTime(0, 0, 0, 'America/Lima');
		$date_1 = CarbonImmutable::createFromTime(0, 0, 0, 'America/Lima');
		foreach ($data as $key => $fecha) {
			if( !$fecha == [] ){
				foreach ($fecha as $key => $office) {
					foreach ($office as $key => $host) {
						foreach ($host as $key => $call) {
							if ( $key != 0 ){
								$nHosts++;
								$start = Carbon::parse($call['call_start']);
								if(!array_key_exists('call_end', $call)){
									$end = Carbon::now();
								}else{
									$end = Carbon::parse($call['call_end']);
								}
								$h = $end->diff($start)->format('%H');
								$m = $end->diff($start)->format('%i');
								$s = $end->diff($start)->format('%s');
								$date_1 = $date_1->addHours($h)->addMinutes($m)->addSeconds($s);
							}
						}
					}
				}
			}
		}
		$h = $date_1->format('H')*60*60;
		$m = $date_1->format('i')*60;
		$s = $date_1->format('s');
		$average = ($h + $m + $s) / $nHosts;
		$cAverage = Carbon::parse($average)->format("H:i:s");

		return $cAverage;

	}



}
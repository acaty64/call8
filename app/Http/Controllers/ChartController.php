<?php

namespace App\Http\Controllers;

use App\Charts\SampleChart;
use App\Http\Traits\ReportScheduleTrait;
use App\Models\Office;
use App\Models\Trace;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;

class ChartController extends Controller
{
	use ReportScheduleTrait;


	public function index(){

		$offices = Office::all();

		return view('statistics.dashboard', [
				'offices' => $offices,
			]);
	}


	public function statistics(Request $request)
	{
        $validate = $request->validate([
            'office_id' => 'required',
        ]);

		$office_id = $request->office_id;
		$office = Office::findOrFail($office_id);

		$date_start = CarbonImmutable::now()->subDays(6);
		$date_end = CarbonImmutable::now();

		$fechas = $this->DateRange($date_start, $date_end);
		$hosts = [];
		$h_attentions = [];
		foreach ($fechas as $key => $value) {
			$_value = substr($value, 0, 10);
			$hosts[] = Trace::whereDate('created_at', $_value)
						->where('host_id', '!=', null)
						->where('office_id', $office_id)
						->pluck('host_id')->unique()->count();
			$h_attentions[] = Trace::whereDate('created_at', $_value)
							->where('client_id', '!=', null)
							->where('office_id', $office_id)
							->where('status_id', 4)
							->count();
		}


		$options_color1 = [
            'backgroundColor'           => 'rgb(127,156,245, 0.4)',
            'borderColor'               => '#2234d6',
            // 'borderColor'               => '#7F9CF5',
            'pointBackgroundColor'      => 'rgb(255, 255, 255, 0)',
            'pointBorderColor'          => 'rgb(255, 255, 255, 0)',
            'pointHoverBackgroundColor' => '#7F9CF5',
            'pointHoverBorderColor'     => '#7F9CF5',
            'borderWidth'               => 1,
            'pointRadius'               => 1,
						        ];
		$options_color2 = [
            'backgroundColor'           => 'rgb(127, 156, 245, 0.4)',
            'borderColor'               => '#A3BFFA',
            'pointBackgroundColor'      => 'rgb(255, 255, 255, 0)',
            'pointBorderColor'          => 'rgb(255, 255, 255, 0)',
            'pointHoverBackgroundColor' => '#A3BFFA',
            'pointHoverBorderColor'     => '#A3BFFA',
            'borderWidth'               => 1,
            'pointRadius'               => 1,
        ];

		$chart = new SampleChart;
		$chart->title('Cantidad de Operadores');
		$chart->labels($fechas);
		$chart->dataset('Operadores', 'line', $hosts)->options($options_color1);
		$chart->dataset('Atenciones', 'line', $h_attentions)->options($options_color2);

		$clients = [];
		$c_attentions = [];
		foreach ($fechas as $key => $value) {
			$clients[] = Trace::whereDate('created_at', $value)
						->where('client_id', '!=', null)
						->where('office_id', $office_id)
						->pluck('client_id')->unique()->count();
			$c_attentions[] = Trace::whereDate('created_at', $value)
							->where('client_id', '!=', null)
							->where('office_id', $office_id)
							->where('status_id', 4)
							->count();
		}
		$chart1 = new SampleChart;
		$chart1->title('Cantidad de Usuarios');
		$chart1->labels($fechas);
		$chart1->dataset('Usuarios', 'line', $clients)->options($options_color1);
		$chart1->dataset('Atenciones', 'line', $c_attentions)->options($options_color2);

		return view('statistics.chart', [
				'chart' => $chart, 
				'chart1' => $chart1,
				'office' => $office,
			]);

	}

	public function test()
	{
		$chart = new SampleChart;
		$chart->labels(['One', 'Two', 'Three', 'Four']);
		$chart->dataset('My dataset 1', 'line', [1, 2, 3, 4]);
		$chart->dataset('My dataset 2', 'line', collect([4, 3, 2, 1]));

		return view('sample_chart2', compact('chart'));
	}


}

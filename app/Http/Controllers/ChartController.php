<?php

namespace App\Http\Controllers;

use App\Charts\SampleChart;
use Illuminate\Http\Request;

class ChartController extends Controller
{
	public function index()
	{
		$chart = new SampleChart;
		$chart->labels(['One', 'Two', 'Three', 'Four']);
		$chart->dataset('My dataset 1', 'line', [1, 2, 3, 4]);
		$chart->dataset('My dataset 2', 'line', collect([4, 3, 2, 1]));

		return view('sample_chart2', compact('chart'));

	}
}

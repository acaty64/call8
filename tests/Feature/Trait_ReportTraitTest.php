<?php

namespace Tests\Feature;

use App\Http\Traits\ReportTraceTrait;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class Trait_ReportTraceTest extends TestCase
{

	use ReportTraceTrait;
	use DatabaseTransactions;


    public function testStatisticHosts()
    {
    	$date_start = CarbonImmutable::now()->subDays(3)->format('Y-m-d');
    	$date_end = CarbonImmutable::now()->addDays(3)->format('Y-m-d');

    	$response = $this->StatisticHosts($date_start, $date_end);

        $this->assertTrue($response != []);
    }

    public function testStatisticClients()
    {
    	$date_start = CarbonImmutable::now()->subDays(3)->format('Y-m-d');
    	$date_end = CarbonImmutable::now()->addDays(3)->format('Y-m-d');

    	$response = $this->StatisticClients($date_start, $date_end);

        $this->assertTrue($response != []);
    }

	public function testHostTimeAverage()
	{
    	$date_start = CarbonImmutable::now()->subDays(3)->format('Y-m-d');
    	$date_end = CarbonImmutable::now()->addDays(3)->format('Y-m-d');

    	$response = $this->HostTimeAverage($date_start, $date_end);

        $this->assertTrue($response != "");
	}

	public function testHostAttentionAverage()
	{
    	$date_start = CarbonImmutable::now()->subDays(3)->format('Y-m-d');
    	$date_end = CarbonImmutable::now()->addDays(3)->format('Y-m-d');

    	$response = $this->HostAttentionAverage($date_start, $date_end);

        $this->assertTrue($response != "");
	}





}





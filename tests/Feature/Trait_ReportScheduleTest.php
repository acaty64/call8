<?php

namespace Tests\Feature;

use App\Http\Traits\ReportScheduleTrait;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class Trait_ReportScheduleTest extends TestCase
{

	use ReportScheduleTrait;
	use DatabaseTransactions;

    public function testScheduleDateRange()
    {
    	$date_start = CarbonImmutable::now()->subDays(3)->format('Y-m-d');
    	$date_end = CarbonImmutable::now()->addDays(3)->format('Y-m-d');

    	$response = $this->ScheduleDateRange($date_start, $date_end);

        $this->assertTrue($response != []);
    }


    public function testScheduleForHost()
    {
    	$date_start = CarbonImmutable::now()->subDays(3)->format('Y-m-d');
    	$date_end = CarbonImmutable::now()->addDays(3)->format('Y-m-d');

    	$response = $this->ScheduleForHost($date_start, $date_end);

        $this->assertTrue($response != []);

    }

    public function testScheduleForOffice()
    {
    	$date_start = CarbonImmutable::now()->subDays(3)->format('Y-m-d');
    	$date_end = CarbonImmutable::now()->addDays(3)->format('Y-m-d');

    	$response = $this->ScheduleForOffice($date_start, $date_end);

        $this->assertTrue($response != []);

    }

}





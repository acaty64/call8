<?php

namespace Tests\Feature;

use App\Http\Traits\ReportTrait;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class Trait_ReportTest extends TestCase
{

	use ReportTrait;
	use DatabaseTransactions;

    public function testScheduleDateRange()
    {
    	$date_start = CarbonImmutable::now()->subDays(3)->format('Y-m-d');
    	$date_end = CarbonImmutable::now()->subDays(3)->format('Y-m-d');

    	$response = $this->ScheduleDateRange($date_start, $date_end);

        $this->assertTrue($response != []);
    }
}

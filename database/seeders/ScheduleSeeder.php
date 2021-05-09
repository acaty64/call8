<?php
namespace Database\Seeders;

use App\Models\Schedule;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


		Schedule::create([
    		'office_id' => 1,
    		'host_id' => 1,
    		'day' => 1,
    		'hour_start' => '08:30',
    		'hour_end' => '12:30',
    		'date_start' => CarbonImmutable::now()->sub(10, 'day'),
    		'date_end' => CarbonImmutable::now()->add(12, 'day'),
		]);

		Schedule::create([
    		'office_id' => 1,
    		'host_id' => 1,
    		'day' => 1,
    		'hour_start' => '14:30',
    		'hour_end' => '16:30',
            'date_start' => CarbonImmutable::now()->sub(10, 'day'),
            'date_end' => CarbonImmutable::now()->add(12, 'day'),
		]);

		Schedule::create([
    		'office_id' => 1,
    		'host_id' => 1,
    		'day' => 2,
    		'hour_start' => '08:30',
    		'hour_end' => '12:30',
            'date_start' => CarbonImmutable::now()->sub(10, 'day'),
            'date_end' => CarbonImmutable::now()->add(12, 'day'),
		]);

		Schedule::create([
    		'office_id' => 1,
    		'host_id' => 1,
    		'day' => 2,
    		'hour_start' => '14:30',
    		'hour_end' => '16:30',
            'date_start' => CarbonImmutable::now()->sub(10, 'day'),
            'date_end' => CarbonImmutable::now()->add(12, 'day'),
		]);
        //************ user 2
        Schedule::create([
            'office_id' => 1,
            'host_id' => 2,
            'day' => 1,
            'hour_start' => '14:30',
            'hour_end' => '16:30',
            'date_start' => CarbonImmutable::now()->sub(10, 'day'),
            'date_end' => CarbonImmutable::now()->add(12, 'day'),
        ]);

        Schedule::create([
            'office_id' => 1,
            'host_id' => 2,
            'day' => 0,         // Domingo
            'hour_start' => '08:30',
            'hour_end' => '10:30',
            'date_start' => CarbonImmutable::now()->sub(10, 'day'),
            'date_end' => CarbonImmutable::now()->add(12, 'day'),
        ]);


    }
}


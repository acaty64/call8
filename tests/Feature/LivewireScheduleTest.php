<?php

namespace Tests\Feature;

use App\Http\Livewire\HostScreen;
use App\Http\Livewire\ScheduleCreate;
use App\Http\Livewire\ScheduleCrud;
use App\Http\Livewire\ScheduleEdit;
use App\Http\Livewire\ScheduleScreen;
use App\Http\Traits\ScheduleTrait;
use App\Models\Office;
use App\Models\Schedule;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class LivewireScheduleTest extends TestCase
{
    use DatabaseTransactions;

    use ScheduleTrait;

    /** @test */
    public function refactoring()
    {
        $user_id = User::find(1)->id;
        $inicio = Carbon::now()->format('Y-m-d');
        $office_id = Office::find(1)->id;

        $schedule = Schedule::find(3);
        $schedule->day = 0;
        $schedule->hour_start = '08:00';
        $schedule->save();

        $response = $this->horario($inicio, $user_id, $office_id);
        $this->assertFalse(empty($response));
    }
    /** @test */
    public function schedule_page_contains_livewire_component()
    {
        $admin = User::find(1);
        $hoy = new Carbon();
        $domingo = $hoy->subDays( $hoy->dayOfWeek );
        $sabado = $hoy->addDays( 6 - $hoy->dayOfWeek );

        Livewire::actingAs($admin)
            ->test(ScheduleScreen::class)
            ->assertSeeHtml('Fecha de inicio')
            ->assertSeeHtml($domingo->format('Y-m-d'))
            ->assertSeeHtml('Fecha de fin')
            ->assertSeeHtml($sabado->format('Y-m-d'));

    }

    /** @test */
    public function admin_can_add_schedule_registry()
    {
        $admin = User::find(1);
        $this->actingAs($admin);
        $this->get(route('schedule.crud'))
                ->assertSeeLivewire('schedule-crud');

        Livewire::actingAs($admin)
            ->test(ScheduleCrud::class)
            ->set('status', 'create')
            ->assertSeeLivewire('schedule-create');

        $data = [
            'host_id' => 3,
            'office_id' => 1,
            'day' => 1,
            'hour_start' => '08:00',
            'hour_end' => '08:59',
            'date_start' => '2021-05-20',
            'date_end' => '2021-05-30',
        ];

        Livewire::actingAs($admin)
            ->test(ScheduleCreate::class)
            ->set('selectedHost', $data['host_id'])
            ->set('selectedOffice', $data['office_id'])
            ->set('selectedDay', $data['day'])
            ->set('hour_start', $data['hour_start'])
            ->set('hour_end', $data['hour_end'])
            ->set('date_start', $data['date_start'])
            ->set('date_end', $data['date_end'])
            ->call('save');
            // ->assertSeeHtml('Registro grabado.');

        $this->assertDatabaseHas('schedules', $data);

    }

    /** @test */
    public function admin_cannot_add_an_error_schedule_registry()
    {

        $admin = User::find(1);
        $this->actingAs($admin);
        $this->get(route('schedule.crud'))
                ->assertSeeLivewire('schedule-crud');

        Livewire::actingAs($admin)
            ->test(ScheduleCrud::class)
            ->set('status', 'create')
            ->assertSeeLivewire('schedule-create');

        $oldSchedule = Schedule::find(1);

        $data = [
            'host_id' => $oldSchedule->host_id,
            'office_id' => $oldSchedule->office_id,
            'day' => $oldSchedule->day,
            'hour_start' => $oldSchedule->hour_start,
            'hour_end' => '18:00',
            'date_start' => $oldSchedule->date_start,
            'date_end' => $oldSchedule->end,
        ];

        Livewire::actingAs($admin)
            ->test(ScheduleCreate::class)
            ->set('selectedHost', $data['host_id'])
            ->set('selectedOffice', $data['office_id'])
            ->set('selectedDay', $data['day'])
            ->set('hour_start', $data['hour_start'])
            ->set('hour_end', $data['hour_end'])
            ->set('date_start', $data['date_start'])
            ->set('date_end', $data['date_end'])
            ->call('save');

        $this->assertDatabaseMissing('schedules', $data);

    }

    /** @test */
    public function admin_can_edit_schedule_registry()
    {
        $admin = User::find(1);
        $this->actingAs($admin);
        $this->get(route('schedule.crud'))
                ->assertSeeLivewire('schedule-crud');

        Livewire::actingAs($admin)
                ->test(ScheduleCrud::class)
                ->call('edit', 1)
                ->assertSeeLivewire('schedule-edit');

        $old_data = Schedule::find(1);

        $data = [
            'id' => $old_data->id,
            'host_id' => 1,
            'office_id' => 3,
            'day' => 1,
            'hour_start' => '10:00',
            'hour_end' => '13:59',
            'date_start' => '2021-05-20',
            'date_end' => '2021-05-30',
        ];

        Livewire::actingAs($admin)
            ->test(ScheduleEdit::class, ['schedule_id' => 1])
            ->set('selectedOffice', $data['office_id'])
            ->set('selectedDay', $data['day'])
            ->set('hour_start', $data['hour_start'])
            ->set('hour_end', $data['hour_end'])
            ->set('date_start', $data['date_start'])
            ->set('date_end', $data['date_end'])
            ->call('save');
            // ->assertSeeHtml('Registro grabado.');

        $this->assertDatabaseHas('schedules', $data);
        $this->assertDatabaseMissing('schedules', $old_data->toArray());

    }


    /** @test */
    public function attention_horary_one_time_zone()
    {
        Carbon::setTestNow();
        $now = CarbonImmutable::now();
        $mockHour = '08';
        $mockMinute = '00';
        $knownDate = Carbon::create($now->format('Y'), $now->format('m'), $now->format('d'), $mockHour, $mockMinute);
        Carbon::setTestNow($knownDate);

        $host = User::find(3);
        $this->assertTrue($host->is_host);
        $now = $knownDate;
        $today = $now->dayOfWeek;

        $m = 59;
        $schedule = Schedule::create([
            'office_id' => 3,
            'host_id' => $host->id,
            'day' => $today,
            'hour_start' => str_pad($now->hour, 2, "00", STR_PAD_LEFT) . ':' . $mockMinute,
            'hour_end' => str_pad($now->hour, 2, "00", STR_PAD_LEFT) . ':' . $m,
            'date_start' => $now->subDays(2)->format('Y-m-d'),
            'date_end' => $now->addDays(2)->format('Y-m-d'),
        ]);


        $vhour_end = str_pad(substr($schedule->hour_start, 0, 2), 2, "00", STR_PAD_LEFT) . ':' . $m;

        $response = $this->horary($schedule->office_id);

        $check = [
            [
                "ini" => str_pad($now->hour, 2, "00", STR_PAD_LEFT) . ':00',
                "fin" => $vhour_end,
            ],

        ];

        $this->assertTrue($response == $check);
    }

    /** @test */
    public function attention_horary_two_times_zone()
    {
        Carbon::setTestNow();
        $now = CarbonImmutable::now();
        $mockHour = '08';
        $mockMinute = '00';
        $knownDate = Carbon::create($now->format('Y'), $now->format('m'), $now->format('d'), $mockHour, $mockMinute);
        Carbon::setTestNow($knownDate);

        $host = User::find(3);
        $this->assertTrue($host->is_host);
        $now = $knownDate;
        $today = $now->dayOfWeek;

        $m = 59;
        $schedule = Schedule::create([
            'office_id' => 3,
            'host_id' => $host->id,
            'day' => $today,
            'hour_start' => str_pad($now->hour, 2, "00", STR_PAD_LEFT) . ':' . $mockMinute,
            'hour_end' => str_pad($now->hour, 2, "00", STR_PAD_LEFT) . ':' . $m,
            'date_start' => $now->subDays(2)->format('Y-m-d'),
            'date_end' => $now->addDays(2)->format('Y-m-d'),
        ]);

        $vhour_init = $schedule->hour_start;

        $schedule = Schedule::create([
            'office_id' => 3,
            'host_id' => $host->id,
            'day' => $today,
            'hour_start' => str_pad($now->hour + 1, 2, "00", STR_PAD_LEFT) . ':' . $mockMinute,
            'hour_end' => str_pad($now->hour + 1, 2, "00", STR_PAD_LEFT) . ':' . $m,
            'date_start' => $now->subDays(2)->format('Y-m-d'),
            'date_end' => $now->addDays(2)->format('Y-m-d'),
        ]);

        $vhour_end = $schedule->hour_end;
        // $vhour_end = str_pad(substr($schedule->hour_start, 0, 2), 2, "00", STR_PAD_LEFT) . ':' . $m;

        $response = $this->horary($schedule->office_id);

        $check = [
            [
                "ini" => $vhour_init,
                "fin" => $vhour_end,
            ],

        ];

        $this->assertTrue($response == $check);
    }

}

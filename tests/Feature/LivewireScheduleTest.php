<?php

namespace Tests\Feature;

use App\Http\Livewire\HostScreen;
use App\Http\Livewire\ScheduleCreate;
use App\Http\Livewire\ScheduleCrud;
use App\Http\Livewire\ScheduleScreen;
use App\Models\Schedule;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class LivewireScheduleTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function schedule_page_contains_livewire_component()
    {
        $host = User::find(1);
        $hoy = new Carbon();
        if($hoy->dayOfWeek == 0){
            $lunes = $hoy->addDay();
        }else{
            $lunes = $hoy->subDays($hoy->dayOfWeek-1);
        }
        $domingo = $lunes->addDays(6);
        Livewire::actingAs($host)
            ->test(ScheduleScreen::class)
            ->assertSeeHtml('Fecha de inicio')
            ->assertSeeHtml($lunes->format('Y-m-d'))
            ->assertSeeHtml('Fecha de fin')
            ->assertSeeHtml($domingo->format('Y-m-d'));

    }

    /** @test */
    public function admin_can_add_schedule_registry()
    {

        $host = User::find(1);
        $this->get(route('schedule.crud'))
                ->assertSeeLivewire('schedule-crud');

        Livewire::actingAs($host)
            ->test(ScheduleCrud::class)
            ->set('status', 'create')
            ->assertSeeLivewire('schedule-create');

        $data = [
            'host_id' => 3,
            'office_id' => 1,
            'day' => 1,
            'hour_start' => '08:00',
            'hour_end' => '09:00',
            'date_start' => '2021-05-20',
            'date_end' => '2021-05-30',
        ];

        Livewire::actingAs($host)
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

        $host = User::find(1);
        $this->actingAs($host);
        $this->get(route('schedule.crud'))
                ->assertSeeLivewire('schedule-crud');

        Livewire::actingAs($host)
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

        Livewire::actingAs($host)
            ->test(ScheduleCreate::class)
            ->set('selectedHost', $data['host_id'])
            ->set('selectedOffice', $data['office_id'])
            ->set('selectedDay', $data['day'])
            ->set('hour_start', $data['hour_start'])
            ->set('hour_end', $data['hour_end'])
            ->set('date_start', $data['date_start'])
            ->set('date_end', $data['date_end'])
            ->call('save');
            // ->assertSeeHtml('Horarios cruzados');
            // ->assertSeeHtml('Error, revise las fechas y horas.');

        $this->assertDatabaseMissing('schedules', $data);


    }




}

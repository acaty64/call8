<?php

namespace Tests\Feature;

use App\Http\Livewire\ClientScreen;
use App\Models\Call;
use App\Models\Schedule;
use App\Models\Status;
use App\Models\User;
use App\Models\Window;
use Carbon\CarbonImmutable;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class LivewireClientTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function client_creation_page_contains_livewire_component_0800()
    {
        Carbon::setTestNow();
        $now = CarbonImmutable::now();
        $mockHour = 8;
        $mockMinute = 0;
        $knownDate = Carbon::create($now->format('Y'), $now->format('m'), $now->format('d'), $mockHour, $mockMinute);
        Carbon::setTestNow($knownDate);
        $check = $this->client_see_schedules_buttons($knownDate);
        $this->assertTrue($check);
    }

    /** @test */
    public function client_creation_page_contains_livewire_component_0830()
    {
        Carbon::setTestNow();
        $now = CarbonImmutable::now();
        $mockHour = 8;
        $mockMinute = 30;
        $knownDate = Carbon::create($now->format('Y'), $now->format('m'), $now->format('d'), $mockHour, $mockMinute);
        $now = Carbon::setTestNow($knownDate);
        $check = $this->client_see_schedules_buttons($knownDate);
        $this->assertTrue($check);
    }

    /** @test */
    public function client_creation_page_contains_livewire_component_0829()
    {
        Carbon::setTestNow();
        $now = CarbonImmutable::now();
        $mockHour = '08';
        $mockMinute = '29';
        $knownDate = Carbon::create($now->format('Y'), $now->format('m'), $now->format('d'), $mockHour, $mockMinute);
        Carbon::setTestNow($knownDate);
        $check = $this->client_see_schedules_buttons($knownDate);
        $this->assertTrue($check);

    }

    /** @test */
    public function client_creation_page_contains_livewire_component_0900()
    {
        Carbon::setTestNow();
        $now = CarbonImmutable::now();
        $mockHour = '09';
        $mockMinute = '00';
        $knownDate = Carbon::create($now->format('Y'), $now->format('m'), $now->format('d'), $mockHour, $mockMinute);
        Carbon::setTestNow($knownDate);
        $check = $this->client_see_schedules_buttons($knownDate);
        $this->assertTrue($check);

    }

    /** @test */
    public function client_creation_page_contains_livewire_component_2030()
    {
        Carbon::setTestNow();
        $now = CarbonImmutable::now();
        $mockHour = '20';
        $mockMinute = '30';
        $knownDate = Carbon::create($now->format('Y'), $now->format('m'), $now->format('d'), $mockHour, $mockMinute);
        Carbon::setTestNow($knownDate);
        $check = $this->client_see_schedules_buttons($knownDate);
        $this->assertTrue($check);

    }

    /** @test */
    public function client_creation_page_contains_livewire_component_2059()
    {
        Carbon::setTestNow();
        $now = CarbonImmutable::now();
        $mockHour = '20';
        $mockMinute = '59';
        $knownDate = Carbon::create($now->format('Y'), $now->format('m'), $now->format('d'), $mockHour, $mockMinute);
        Carbon::setTestNow($knownDate);
        $check = $this->client_see_schedules_buttons($knownDate);
        $this->assertTrue($check);

    }

    /** @test */
    public function client_creation_page_contains_livewire_component_2100_is_false()
    {
        Carbon::setTestNow();
        $now = CarbonImmutable::now();
        $mockHour = '21';
        $mockMinute = '00';
        $knownDate = Carbon::create($now->format('Y'), $now->format('m'), $now->format('d'), $mockHour, $mockMinute);
        Carbon::setTestNow($knownDate);
        $check = $this->client_dont_see_schedules_buttons($knownDate);
        $this->assertTrue($check);

    }

    public function client_see_schedules_buttons($knownDate)
    {

        $now = $knownDate;

        $h_end = $now->format('H');
        if($now->format('i') > 29){
            $m_init = 30;
            $m_end = 59;
        }else{
            $m_init = 00;
            $m_end = 29;
        }
        $schedule = Schedule::create([
            'office_id' => 1,
            'host_id' => 1,
            'day' => $now->dayOfWeek,
            'hour_start' => $now->format('H') . ":" . $m_init,
            'hour_end' => $h_end . ":" . $m_end,
            'date_start' => $now->format('Y-m-d'),
            'date_end' => Carbon::create($now->format('Y'), $now->format('m'), $now->format('d')+1)->format('Y-m-d'),
        ]);

        $user = User::find(7);
        $xx = Livewire::actingAs($user)
            ->test(ClientScreen::class)
            ->assertSeeHtml('HORARIOS DE ATENCIÓN')
            ->assertSeeHtml('seleccione la oficina con la que desea comunicarse.');
            // ->set('office_id', null)
        return true;

    }

    public function client_dont_see_schedules_buttons($knownDate)
    {

        $now = $knownDate;

        $h_end = $now->format('H');
        if($now->format('i') > 29){
            $m_init = 30;
            $m_end = 59;
        }else{
            $m_init = 00;
            $m_end = 29;
        }
        $schedule = Schedule::create([
            'office_id' => 1,
            'host_id' => 1,
            'day' => $now->dayOfWeek,
            'hour_start' => $now->format('H') . ":" . $m_init,
            'hour_end' => $h_end . ":" . $m_end,
            'date_start' => $now->format('Y-m-d'),
            'date_end' => Carbon::create($now->format('Y'), $now->format('m'), $now->format('d')+1)->format('Y-m-d'),
        ]);

        $user = User::find(7);
        $xx = Livewire::actingAs($user)
            ->test(ClientScreen::class)
            ->assertSeeHtml('HORARIOS DE ATENCIÓN')
            ->assertSeeHtml('No hay operadores programados, revise los horarios de atención.');
            // ->set('office_id', null)
        return true;

    }

    /** @test */
    public function client_with_previous_access_page_view_livewire_component()
    {
        $call = Call::where('client_id', 4)->first();
        $call->status_id = 1;
        $call->save();

        $user = User::find(4);
        Livewire::actingAs($user)
            ->test(ClientScreen::class)
            ->set('office_id', '1')
            // ->assertSeeHtml('El horario de atención de hoy en Oficina de Asuntos Académicos es:')
            ->assertSeeHtml('Poner en Cola');
    }

    /** @test */
    public function call_creation_page_doesnt_contain_livewire_component()
    {
        $user = User::find(1);
        $this->actingAs($user);
        $this->get(route('call.client'))->assertDontSeeLivewire('host-screen');
    }

    /** @test */
    public function client_click_poner_en_cola()
    {
        $user = User::find(6);
        Livewire::actingAs($user)
            ->test(ClientScreen::class)
            ->set('office_id', 1)
            ->call('wait');

        $status_paused = Status::where('status', 'En Pausa')->first();

        $this->assertDatabaseHas('calls', [
            'client_id' => $user->id,
            'status_id' => $status_paused->id,
        ]);

        $this->assertDatabaseHas('traces', [
            'client_id' => $user->id,
            'status_id' => $status_paused->id
        ]);

    }

    /** @test */
    public function client_click_responder()
    {
        $status_paused = Status::where('status', 'En Pausa')->first()->id;
        $client = User::find(6);
        $call = Call::where('client_id', $client->id)->first();
        $call->status_id = $status_paused;
        $call->save();

        $window = Window::find(3);
        $window->host_id = 3;
        $window->client_id = $client->id;
        $window->call_id = $call->id;
        $window->save();

        Livewire::actingAs($client)
            ->test(ClientScreen::class)
            ->set('call_id', $call->id)
            ->call('answer');

        $status_answer = Status::where('status', 'Atendiendo')->first();

        $this->assertDatabaseHas('windows', [
            'client_id' => $client->id,
            'status_id' => $status_answer->id,
        ]);

        $this->assertDatabaseHas('calls', [
            'client_id' => $client->id,
            'status_id' => $status_answer->id,
        ]);

        $this->assertDatabaseHas('traces', [
            'client_id' => $client->id,
            'status_id' => $status_answer->id
        ]);

    }

    /** @test */
    public function client_click_colgar()
    {
        $client = User::find(4);
        $call = Call::where('client_id', $client->id)->first();

        $window = Window::find(1);
        $window->client_id = $client->id;
        $window->call_id = $call->id;
        $window->save();

        Livewire::actingAs($client)
            ->test(ClientScreen::class)
            ->set('call_id', $call->id)
            ->call('stop');

        $status_closed = Status::where('status', 'Cerrado')->first();

        $status_paused = Status::where('status', 'En Pausa')->first();

        $this->assertDatabaseHas('windows', [
            'id' => $window->id,
            'client_id' => null,
            'status_id' => $status_paused->id,
        ]);

        $this->assertDatabaseHas('calls', [
            'id' => $call->id,
            'client_id' => $client->id,
            'status_id' => $status_closed->id,
        ]);

        $this->assertDatabaseHas('traces', [
            'call_id' => $call->id,
            'client_id' => $client->id,
            'status_id' => $status_closed->id
        ]);

    }


}

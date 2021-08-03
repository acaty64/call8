<?php

namespace Tests\Feature;

use App\Http\Livewire\HostScreen;
use App\Models\Call;
use App\Models\Schedule;
use App\Models\Status;
use App\Models\User;
use App\Models\Window;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class LivewireHostTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function host_creation_page_contains_livewire_component()
    {
        $status_paused = Status::where('status', 'En Pausa')->first()->id;
        $host = User::find(3);

        $now = Carbon::now();
        Schedule::create([
            'office_id' => 1,
            'host_id' => $host->id,
            'day' => $now->dayOfWeek,
            'hour_start' => str_pad($now->hour, 2, "00", STR_PAD_LEFT) . ':00',
            'hour_end' => str_pad($now->hour + 1, 2, "00", STR_PAD_LEFT) . ':00',
            'date_start' => $now->subDays(2)->format('Y-m-d'),
            'date_end' => $now->addDays(2)->format('Y-m-d'),
        ]);

        Livewire::actingAs($host)
            ->test(HostScreen::class)
            ->assertSeeHtml('Libre')
            ->assertSeeHtml('Salir');

        $this->assertDatabaseHas('windows', [
            'host_id' => $host->id,
            'status_id' => $status_paused,
        ]);
    }

    /** @test */
    public function call_creation_page_doesnt_contain_livewire_component()
    {
        $user = User::find(1);
        $this->actingAs($user);
        $this->get(route('call.client'))->assertDontSeeLivewire('host-screen');
    }

    /** @test */
    public function a_host_can_open_a_new_window()
    {
        $status_id = Status::where('status', 'Cerrado')->first()->id;
        $window = Window::find(3);
        $window->host_id = null;
        $window->status_id = $status_id;
        $window->save();

        $host = User::find(3);

        $now = Carbon::now();
        Schedule::create([
            'office_id' => 1,
            'host_id' => $host->id,
            'day' => $now->dayOfWeek,
            'hour_start' => str_pad($now->hour, 2, "00", STR_PAD_LEFT) . ':00',
            'hour_end' => str_pad($now->hour + 1, 2, "00", STR_PAD_LEFT) . ':00',
            'date_start' => $now->subDays(2)->format('Y-m-d'),
            'date_end' => $now->addDays(2)->format('Y-m-d'),
        ]);

        Livewire::actingAs($host)
            ->test(HostScreen::class)
            ->call('openWindow')
            ->assertSeeHtml('Libre')
            ->assertSeeHtml('Salir');
    }

    // /** @test */
    // public function a_host_can_reopen_a_window()
    // {
    //     $status_id = Status::where('status', 'Atendiendo')->first()->id;
    //     $user = User::find(1);
    //     $user->window->status_id = $status_id;
    //     $user->window->client_id = 1;
    //     $user->window->call_id = 1;
    //     $user->window->save();

    //     Livewire::actingAs($user)
    //         ->test(HostScreen::class)
    //         ->set('status', 'Atendiendo')
    //         ->call('openWindow')
    //         ->assertSeeHtml('Conectar');
    // }

    /** @test */
    public function when_host_click_Libre()
    {

        // $status_paused = Status::where('status', 'En Pausa')->first()->id;

        $host = User::find(1);
        $now = Carbon::now();

        Schedule::create([
            'office_id' => 1,
            'host_id' => $host->id,
            'day' => $now->dayOfWeek,
            'hour_start' => str_pad($now->hour, 2, "00", STR_PAD_LEFT) . ':00',
            'hour_end' => str_pad($now->hour + 1, 2, "00", STR_PAD_LEFT) . ':00',
            'date_start' => $now->subDays(2)->format('Y-m-d'),
            'date_end' => $now->addDays(2)->format('Y-m-d'),
        ]);

        Livewire::actingAs($host)
            ->test(HostScreen::class)
            ->call('free')
            ->assertSeeHtml('Llamar')
            ->assertSeeHtml('Salir');
    }

    /** @test */
    public function when_host_click_Llamar()
    {
        $host = User::find(1);

        $now = Carbon::now();
        Schedule::create([
            'office_id' => 1,
            'host_id' => $host->id,
            'day' => $now->dayOfWeek,
            'hour_start' => str_pad($now->hour, 2, "00", STR_PAD_LEFT) . ':00',
            'hour_end' => str_pad($now->hour + 1, 2, "00", STR_PAD_LEFT) . ':00',
            'date_start' => $now->subDays(2)->format('Y-m-d'),
            'date_end' => $now->addDays(2)->format('Y-m-d'),
        ]);

        Livewire::actingAs($host)
            ->test(HostScreen::class)
            ->call('startWindow')
            ->assertRedirect(route('call.host'));
//            ->assertSeeHtml('Colgar');
    }

    /** @test */
    public function when_host_click_Colgar()
    {
        $host = User::find(1);

        $now = Carbon::now();
        Schedule::create([
            'office_id' => 1,
            'host_id' => $host->id,
            'day' => $now->dayOfWeek,
            'hour_start' => str_pad($now->hour, 2, "00", STR_PAD_LEFT) . ':00',
            'hour_end' => str_pad($now->hour + 1, 2, "00", STR_PAD_LEFT) . ':00',
            'date_start' => $now->subDays(2)->format('Y-m-d'),
            'date_end' => $now->addDays(2)->format('Y-m-d'),
        ]);

        Livewire::actingAs($host)
            ->test(HostScreen::class)
            ->call('stopWindow')
            ->assertSeeHtml('En Pausa')
            ->assertSeeHtml('Salir');
    }

    /** @test */
    public function when_host_click_En_Pausa()
    {
        $host = User::find(1);
        
        $now = Carbon::now();
        Schedule::create([
            'office_id' => 1,
            'host_id' => $host->id,
            'day' => $now->dayOfWeek,
            'hour_start' => str_pad($now->hour, 2, "00", STR_PAD_LEFT) . ':00',
            'hour_end' => str_pad($now->hour + 1, 2, "00", STR_PAD_LEFT) . ':00',
            'date_start' => $now->subDays(2)->format('Y-m-d'),
            'date_end' => $now->addDays(2)->format('Y-m-d'),
        ]);

        Livewire::actingAs($host)
            ->test(HostScreen::class)
            ->call('pauseWindow')
            ->assertSeeHtml('Libre')
            ->assertSeeHtml('Salir');
    }

    /** @test */
    public function when_host_click_Salir()
    {
        $host = User::find(1);
        $now = Carbon::now();
        Schedule::create([
            'office_id' => 1,
            'host_id' => $host->id,
            'day' => $now->dayOfWeek,
            'hour_start' => str_pad($now->hour, 2, "00", STR_PAD_LEFT) . ':00',
            'hour_end' => str_pad($now->hour + 1, 2, "00", STR_PAD_LEFT) . ':00',
            'date_start' => $now->subDays(2)->format('Y-m-d'),
            'date_end' => $now->addDays(2)->format('Y-m-d'),
        ]);
        Livewire::actingAs($host)
            ->test(HostScreen::class)
            ->call('outWindow')
            ->assertRedirect(route('stop.host'));

            // ->assertSeeHtml('Cerrado');
    }








}

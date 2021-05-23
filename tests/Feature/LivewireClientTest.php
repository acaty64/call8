<?php

namespace Tests\Feature;

use App\Http\Livewire\ClientScreen;
use App\Models\Call;
use App\Models\Status;
use App\Models\User;
use App\Models\Window;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class LivewireClientTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function client_creation_page_contains_livewire_component()
    {

        if(CarbonImmutable::now()->format('H') > 21){
               $this->markTestIncomplete();
        }

        $user = User::find(7);
        Livewire::actingAs($user)
            ->test(ClientScreen::class)
            ->set('office_id', '')
            ->assertSeeHtml('Bienvenido, ')
            ->assertSeeHtml('seleccione la oficina con la que desea comunicarse.');
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
            ->assertSeeHtml('El horario de atención de hoy en Oficina de Asuntos Académicos es:')
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

<?php

namespace Tests\Feature;

use App\Http\Livewire\ClientScreen;
use App\Models\Call;
use App\Models\Status;
use App\Models\User;
use App\Models\Window;
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
        $call = Call::where('user_id', 6)->first();
        $call->status_id = 1;
        $call->save();

        $user = User::find(6);
        Livewire::actingAs($user)
            ->test(ClientScreen::class)
            ->assertSeeHtml('Bienvenido')
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
            ->call('wait');

        $status_paused = Status::where('status', 'En Pausa')->first();

        $this->assertDatabaseHas('calls', [
            'user_id' => $user->id,
            'status_id' => $status_paused->id,
        ]);

        $this->assertDatabaseHas('traces', [
            'user_id' => $user->id,
            'status_id' => $status_paused->id
        ]);

    }

    /** @test */
    public function client_click_responder()
    {
        $status_paused = Status::where('status', 'En Pausa')->first()->id;
        $client = User::find(6);
        $call = Call::where('user_id', $client->id)->first();
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
            'user_id' => $client->id,
            'status_id' => $status_answer->id,
        ]);

        $this->assertDatabaseHas('traces', [
            'user_id' => $client->id,
            'status_id' => $status_answer->id
        ]);

    }

    /** @test */
    public function client_click_colgar()
    {
        $client = User::find(4);
        $call = Call::where('user_id', $client->id)->first();

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
            'user_id' => $client->id,
            'status_id' => $status_closed->id,
        ]);

        $this->assertDatabaseHas('traces', [
            'call_id' => $call->id,
            'user_id' => $client->id,
            'status_id' => $status_closed->id
        ]);

    }


}

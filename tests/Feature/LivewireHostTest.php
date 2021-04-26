<?php

namespace Tests\Feature;

use App\Http\Livewire\ClientScreen;
use App\Models\Status;
use App\Models\User;
use App\Models\Window;
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
//        $window = Window::where('host_id', $user->id)->first();
//        $window->status_id = $status_paused;
//        $window->save();
        Livewire::actingAs($host)
            ->test(ClientScreen::class)
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

        $user = User::find(3);

        Livewire::actingAs($user)
            ->test(ClientScreen::class)
            ->call('openWindow')
            ->assertSeeHtml('Libre')
            ->assertSeeHtml('Salir');
    }

    /** @test */
    public function a_host_can_reopen_a_window()
    {
        $user = User::find(1);

        Livewire::actingAs($user)
            ->test(ClientScreen::class)
            ->call('openWindow')
            ->assertSeeHtml('Colgar');
    }

}

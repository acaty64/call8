<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LivewireClientTest extends TestCase
{
    /** @test */
    public function call_creation_page_contains_livewire_component()
    {
        $user = User::find(1);
        $this->actingAs($user);
        $this->get(route('call.screen'))->assertSeeLivewire('client-screen');
    }

    /** @test */
    public function call_creation_page_doesnt_contain_livewire_component()
    {
        $user = User::find(1);
        $this->actingAs($user);
        $this->get(route('call.screen'))->assertDontSeeLivewire('host-screen');
    }

}

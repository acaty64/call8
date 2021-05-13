<?php

namespace Tests\Feature\Access;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HostAccessTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function an_admin_user_can_view_host_screen()
    {
        $admin = User::find(3);
        $this->actingAs($admin);
        $response = $this->get('/call/host');
        $response->assertStatus(200);
    }

    /** @test */
    public function a_host_user_can_view_host_screen()
    {
        $host = User::find(2);
        $this->actingAs($host);
        $response = $this->get('/call/host');
        $response->assertStatus(200);
    }

    /** @test */
    public function a_client_user_cannot_view_host_screen()
    {
        $client = User::find(4);
        $this->actingAs($client);
        $response = $this->get('/call/host');
        $response->assertStatus(403);
    }


}

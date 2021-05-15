<?php

namespace Tests\Feature\Routes;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClientRoutesTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function a_master_user_can_view_client_screen()
    {
        $master = User::find(1);
        $this->assertTrue($master->is_master);
        $this->actingAs($master);
        $response = $this->get('/call/client');
        $response->assertStatus(200);
    }

    /** @test */
    public function an_admin_user_can_view_client_screen()
    {
        $admin = User::find(2);
        $this->assertTrue($admin->is_admin);
        $this->actingAs($admin);
        $response = $this->get('/call/client');
        $response->assertStatus(200);
    }

    /** @test */
    public function a_host_user_can_view_client_screen()
    {
        $host = User::find(3);
        $this->assertTrue($host->is_host);
        $this->actingAs($host);
        $response = $this->get('/call/client');
        $response->assertStatus(200);
    }

    /** @test */
    public function a_client_user_can_view_client_screen()
    {
        $client = User::find(4);
        $this->assertTrue($client->is_client);
        $this->actingAs($client);
        $response = $this->get('/call/client');
        $response->assertStatus(200);
    }


}

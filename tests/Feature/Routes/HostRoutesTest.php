<?php

namespace Tests\Feature\Routes;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HostRoutesTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function a_master_user_can_view_host_screen()
    {
        $master = User::find(1);
        $this->actingAs($master);
        $this->assertTrue($master->is_master);
        $response = $this->get('/call/host');
        $response->assertStatus(200);
    }

    /** @test */
    public function an_admin_user_can_view_host_screen()
    {
        $admin = User::find(2);
        $this->assertTrue($admin->is_admin);
        $this->assertFalse($admin->is_master);
        $this->actingAs($admin);
        $response = $this->get('/call/host');
        $response->assertStatus(200);
    }

    /** @test */
    public function a_host_user_can_view_host_screen()
    {
        $host = User::find(3);
        $this->assertTrue($host->is_host);
        $this->assertFalse($host->is_admin);
        $this->assertFalse($host->is_master);
        $this->actingAs($host);
        $response = $this->get('/call/host');
        $response->assertStatus(200);
    }

    /** @test */
    public function a_client_user_cannot_view_host_screen()
    {
        $client = User::find(4);
        $this->assertTrue($client->is_client);
        $this->assertFalse($client->is_host);
        $this->assertFalse($client->is_admin);
        $this->assertFalse($client->is_master);
        $this->actingAs($client);
        $response = $this->get('/call/host');
        $response->assertStatus(403);
    }

    /** @test */
    public function a_master_user_can_view_vue_tests()
    {
        $master = User::find(1);
        $this->assertTrue($master->is_master);
        $this->actingAs($master);
        $response = $this->get('/test/vue');
        $response->assertStatus(200);
    }

    /** @test */
    public function a_master_user_can_view_livewire_tests()
    {
        $master = User::find(1);
        $this->assertTrue($master->is_master);
        $this->actingAs($master);
        $response = $this->get('/test/livewire');
        $response->assertStatus(200);
    }

    /** @test */
    public function non_master_user_cannot_view_tests()
    {
        $host = User::find(3);
        $this->assertFalse($host->is_master);
        $this->actingAs($host);
        $response = $this->get('/test/vue');
        $response->assertStatus(403);
    }

}

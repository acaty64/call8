<?php

namespace Tests\Feature\Routes;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminRoutesTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function an_admin_user_can_view_schedule_screen()
    {
        $admin = User::find(2);
        $this->assertTrue($admin->is_admin);
        $this->actingAs($admin);
        $response = $this->get('/schedule');
        $response->assertStatus(200);
    }

    /** @test */
    public function a_master_user_can_view_schedule_screen()
    {
        $master = User::find(1);
        $this->assertTrue($master->is_master);
        $this->actingAs($master);
        $response = $this->get('/schedule');
        $response->assertStatus(200);
    }

    /** @test */
    public function a_host_user_cannot_view_schedule_screen()
    {
        $host = User::find(3);
        $this->assertFalse($host->is_admin);
        $this->actingAs($host);
        $response = $this->get('/schedule');
        $response->assertStatus(403);
    }

    /** @test */
    public function a_client_user_cannot_view_schedule_screen()
    {
        $client = User::find(4);
        $this->assertFalse($client->is_admin);
        $this->actingAs($client);
        $response = $this->get('/schedule');
        $response->assertStatus(403);
    }

    public function an_admin_user_can_view_window_screen()
    {
        $admin = User::find(2);
        $this->assertTrue($admin->is_admin);
        $this->assertFalse($admin->is_master);
        $this->actingAs($admin);
        $response = $this->get('/windows/index');
        $response->assertStatus(200);
    }

    /** @test */
    public function a_host_user_cannot_view_window_screen()
    {
        $host = User::find(3);
        $this->assertFalse($host->is_admin);
        $this->actingAs($host);
        $response = $this->get('/windows/index');
        $response->assertStatus(403);
    }


    /** @test */
    public function an_admin_user_can_view_call_index()
    {
        $admin = User::find(2);
        $this->assertTrue($admin->is_admin);
        $this->assertFalse($admin->is_master);
        $this->actingAs($admin);
        $response = $this->get('/calls/index');
        $response->assertStatus(200);
    }

    /** @test */
    public function non_admin_user_cannot_view_call_index()
    {
        $host = User::find(3);
        $this->assertFalse($host->is_admin);
        $this->actingAs($host);
        $response = $this->get('/calls/index');
        $response->assertStatus(403);
    }

    /** @test */
    public function an_admin_user_can_view_user_index()
    {
        $admin = User::find(2);
        $this->assertTrue($admin->is_admin);
        $this->assertFalse($admin->is_master);
        $this->actingAs($admin);
        $response = $this->get(route('users.index'));
        $response->assertStatus(200);
    }

    /** @test */
    public function non_admin_user_cannot_view_user_index()
    {
        $host = User::find(3);
        $this->assertFalse($host->is_admin);
        $this->actingAs($host);
        $response = $this->get(route('users.index'));
        $response->assertStatus(403);
    }

    /** @test */
    public function an_admin_user_can_view_link_index()
    {
        $admin = User::find(2);
        $this->assertTrue($admin->is_admin);
        $this->assertFalse($admin->is_master);
        $this->actingAs($admin);
        $response = $this->get(route('links.index'));
        $response->assertStatus(200);
    }

    /** @test */
    public function non_admin_user_cannot_view_link_index()
    {
        $host = User::find(3);
        $this->assertFalse($host->is_admin);
        $this->actingAs($host);
        $response = $this->get(route('links.index'));
        $response->assertStatus(403);
    }


//////////////////////////////////////////////////////
    /** @test */
    public function an_admin_user_can_view_document_index()
    {
        $admin = User::find(2);
        $this->assertTrue($admin->is_admin);
        $this->assertFalse($admin->is_master);
        $this->actingAs($admin);
        $response = $this->get(route('documents.index'));
        $response->assertStatus(200);
    }

    /** @test */
    public function non_admin_user_cannot_view_document_index()
    {
        $host = User::find(3);
        $this->assertFalse($host->is_admin);
        $this->actingAs($host);
        $response = $this->get(route('documents.index'));
        $response->assertStatus(403);
    }


}

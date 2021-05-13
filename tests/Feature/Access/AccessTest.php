<?php

namespace Tests\Feature\Access;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccessTest extends TestCase
{
    /** @test */
    public function an_admin_user_can_view_schedule_screen()
    {
        $this->markTestIncomplete('TODO');
        $admin = User::find(1);

        $this->actingAs($admin);
        $response = $this->get('/schedule');

        $response->assertStatus(200);
    }

    /** @test */
    public function a_host_user_cannot_view_schedule_screen()
    {
        $this->markTestIncomplete('TODO');
        $host = User::find(2);
        $this->actingAs($host);

        $response = $this->get('/schedule');

        $response->assertStatus(403);
    }

    /** @test */
    public function a_client_user_cannot_view_schedule_screen()
    {
        $this->markTestIncomplete('TODO');
        $client = User::find(4);
        $this->actingAs($client);

        $response = $this->get('/schedule');

        $response->assertStatus(403);
    }



}

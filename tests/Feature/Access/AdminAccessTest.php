<?php

namespace Tests\Feature\Access;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function an_admin_user_can_view_schedule_screen()
    {
        $admin = User::find(1);
        $this->actingAs($admin);
        $response = $this->get('/schedule');
        $response->assertStatus(200);
    }

    /** @test */
    public function a_host_user_cannot_view_schedule_screen()
    {
        $host = User::find(2);
        $this->actingAs($host);
        $response = $this->get('/schedule');
        $response->assertStatus(403);
    }

    /** @test */
    public function a_client_user_cannot_view_schedule_screen()
    {
        $client = User::find(4);
        $this->actingAs($client);
        $response = $this->get('/schedule');
        $response->assertStatus(403);
    }

    public function an_admin_user_can_view_window_screen()
    {
        $admin = User::find(1);
        $this->actingAs($admin);
        $response = $this->get('/window/index');
        $response->assertStatus(200);
    }

    /** @test */
    public function a_host_user_cannot_view_window_screen()
    {
        $host = User::find(2);
        $this->actingAs($host);
        $response = $this->get('/window/index');
        $response->assertStatus(403);
    }

    /** @test */
    public function an_admin_user_can_view_tests()
    {
        $admin = User::find(1);
        $this->actingAs($admin);
        $response = $this->get('/tests');
        $response->assertStatus(200);
    }

    /** @test */
    public function non_admin_user_cannot_view_tests()
    {
        $host = User::find(2);
        $this->actingAs($host);
        $response = $this->get('/tests');
        $response->assertStatus(403);
    }

    /** @test */
    public function an_admin_user_can_view_call_index()
    {
        $admin = User::find(1);
        $this->actingAs($admin);
        $response = $this->get('/call/index');
        $response->assertStatus(200);
    }

    /** @test */
    public function non_admin_user_cannot_view_call_index()
    {
        $host = User::find(2);
        $this->actingAs($host);
        $response = $this->get('/call/index');
        $response->assertStatus(403);
    }

    /** @test */
    public function an_admin_user_can_view_user_index()
    {
        $admin = User::find(1);
        $this->actingAs($admin);
        $response = $this->get(route('users.index'));
        $response->assertStatus(200);
    }

    /** @test */
    public function non_admin_user_cannot_view_user_index()
    {
        $host = User::find(2);
        $this->actingAs($host);
        $response = $this->get(route('users.index'));
        $response->assertStatus(403);
    }

    /** @test */
    public function an_admin_user_can_view_user_create()
    {
        $admin = User::find(1);
        $this->actingAs($admin);
        $response = $this->get(route('user.create'));
        $response->assertStatus(200);
    }

    /** @test */
    public function non_admin_user_cannot_view_user_create()
    {
        $host = User::find(2);
        $this->actingAs($host);
        $response = $this->get(route('user.create'));
        $response->assertStatus(403);
    }

    /** @test */
    public function an_admin_user_can_store_a_user()
    {
        $admin = User::find(1);
        $data = [
            'name' => 'Jane Doe',
            'email' => 'janeDoe@gmail.com',
            'password' => bcrypt('secret'),
            'code' => '1234567'
        ];
        $this->actingAs($admin);
        $response = $this->post(route('user.store', $data));
        $response->assertStatus(302);
                // ->assertRedirect'user.create');
    }

    /** @test */
    public function non_admin_user_cannot_store_a_user()
    {
        $host = User::find(2);
        $data = [
            'name' => 'Jane Doe',
            'email' => 'janeDoe@gmail.com',
            'password' => bcrypt('secret'),
            'code' => '1234567'
        ];
        $this->actingAs($host);
        $response = $this->post(route('user.store', $data));
        $response->assertStatus(403);
    }

    /** @test */
    public function an_admin_user_can_see_edit_user()
    {
        $admin = User::find(1);
        $this->actingAs($admin);
        $response = $this->get('user/2/edit');
        $response->assertStatus(200);
    }

    /** @test */
    public function non_admin_user_cannot_see_edit_user()
    {
        $host = User::find(2);
        $this->actingAs($host);
        $response = $this->get('user/2/edit');
        $response->assertStatus(403);
    }



}

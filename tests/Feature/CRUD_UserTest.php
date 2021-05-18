<?php

namespace Tests\Feature;

use App\Models\User;
use App\StatusUser;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CRUD_UserTest extends TestCase
{
    use DatabaseTransactions;

    public function test_user_index_view()
    {
        $user = User::find(1);
        $this->actingAs($user);
        $response = $this->get('/users/index');
        $response->assertStatus(200);
    }

    // public function test_create_a_user()
    // {
    //     $user = User::find(1);
    //     $this->actingAs($user);
    //     $response = $this->get('/user/create');
    //     $response->AssertViewIs('app.user.create');
    //     $response->assertStatus(200);
    // }

    // public function test_store_a_new_user()
    // {
    //     $user = User::find(1);
    //     $this->actingAs($user);
    //     $request = [
    //         'name' => 'Jane Doe',
    //         'code' => '12345678901',
    //         'email' => 'janed@gmail.com',
    //         'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
    //     ];

    //     $response = $this->post(route('user.store') , $request);

    //     $this->assertDatabaseHas('users', $request);
    //     $response->assertStatus(302);
    //     $response->assertRedirect(route('user.create'));
    // }

    // public function test_edit_a_user()
    // {
    //     $user = User::find(1);
    //     $this->actingAs($user);
    //     $response = $this->get('/user/1/edit');
    //     $response->assertStatus(200);
    // }

    // public function test_update_a_user()
    // {

    //     $user = User::find(1);
    //     $this->actingAs($user);
    //     $request = [
    //         'id' => $user->id,
    //         'name' => 'New Master',
    //         'code' => '10987654321',
    //         'email' => 'newMaster@gmail.com',
    //     ];

    //     $response = $this->post(route('user.update'), $request);

    //     $this->assertDatabaseHas('users', $request);
    //     $response->assertStatus(302);
    //     $response->assertRedirect(route('users.index'));
    // }

    // public function test_delete_a_user()
    // {

    //     $host = User::find(1);
    //     $this->actingAs($host);

    //     $user = User::findOrFail(4);
    //     $response = $this->delete(route('user.destroy' , $user->id));

    //     $response->assertStatus(302);

    //     $this->assertDatabaseMissing('users', [
    //             'id' => $user->id,
    //             'name' => $user->name,
    //         ]);

    //     $this->assertDatabaseMissing('calls', [
    //             'client_id' => $user->id,
    //         ]);

    //     $this->assertDatabaseMissing('windows', [
    //             'host_id' => $user->id,
    //         ]);

    //     $this->assertDatabaseMissing('windows', [
    //             'client_id' => $user->id,
    //         ]);

    //     $this->assertDatabaseMissing('traces', [
    //             'client_id' => $user->id,
    //         ]);

    //     $this->assertDatabaseMissing('traces', [
    //             'host_id' => $user->id,
    //         ]);

    // }


}


<?php

namespace Tests\Feature;

use App\Models\Call;
use App\Models\Status;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CRUD_WindowTest extends TestCase
{
    use DatabaseTransactions;

    public function test_windows_index_view()
    {
        $user = User::find(1);
        $this->actingAs($user);
        $response = $this->get(route('window.index'));
        $response->assertStatus(200);
        $response->assertViewIs('app.window.index');
    }

    public function test_open_a_new_window()
    {
        $user = User::findOrFail(4);

        $this->actingAs($user);

        $status = Status::where('status', 'En Pausa')->first();

        $response = $this->post(route('window.open'));

        $this->assertDatabaseHas('windows', [
            'host_id' => $user->id,
            'status_id' => $status->id,
        ]);

        $this->assertDatabaseHas('traces', [
            'user_id' => $user->id,
            'window_id' => $response['id'],
            'status_id' => $status->id
        ]);

        $response->assertStatus(200);
    }

    public function test_set_free_a_window()
    {
        $user = User::findOrFail(3);

        $this->actingAs($user);

        $status = Status::where('status', 'Libre')->first();

        $response = $this->post(route('window.free'));

        $this->assertDatabaseHas('windows', [
            'host_id' => $user->id,
            'status_id' => $status->id,
        ]);

        $this->assertDatabaseHas('traces', [
            'user_id' => $user->id,
            'window_id' => $response['id'],
            'status_id' => $status->id
        ]);

        $response->assertStatus(200);
    }

    public function test_hangUp_a_call()
    {
        $user = User::findOrFail(2);

        $this->actingAs($user);

        $status = Status::where('status', 'En Pausa')->first();

        $array = [
            'user_id' => $user->id,
            'status_id' => $status->id,
        ];

        $response = $this->post(route('window.hang'), $array);

        $this->assertDatabaseHas('windows', [
            'host_id' => $user->id,
            'status_id' => $status->id,
        ]);

        $this->assertDatabaseHas('traces', [
            'user_id' => $user->id,
            'window_id' => $response['id'],
            'status_id' => $status->id
        ]);
    }

    public function test_close_a_window()
    {
        $user = User::findOrFail(1);

        $this->actingAs($user);

        $status = Status::where('status', 'Cerrado')->first();

        $array = [
            'user_id' => $user->id,
            'status_id' => $status->id,
        ];

        $response = $this->post(route('window.close'), $array);

        $this->assertDatabaseHas('windows', [
            'host_id' => $user->id,
            'status_id' => $status->id,
        ]);

        $this->assertDatabaseHas('traces', [
            'user_id' => $user->id,
            'window_id' => $response['id'],
            'status_id' => $status->id
        ]);

    }


}


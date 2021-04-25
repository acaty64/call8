<?php

namespace Tests\Feature;

use App\Http\Traits\WindowTrait;
use App\Models\Call;
use App\Models\Status;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class Trait_WindowTest extends TestCase
{
    use DatabaseTransactions;

    use WindowTrait;

    public function test_open_a_new_window()
    {
        $user = User::findOrFail(4);

        $this->actingAs($user);

        $status = Status::where('status', 'En Pausa')->first();

        $response = $this->open();

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

    public function test_reopen_a_window()
    {
        $user = User::findOrFail(4);
        $this->actingAs($user);
        $response = $this->open();

        $first_id = $response['id'];

        $status = Status::where('status', 'En Pausa')->first();

        $this->assertDatabaseHas('windows', [
            'host_id' => $user->id,
            'status_id' => $status->id,
        ]);

        $this->assertDatabaseHas('traces', [
            'user_id' => $user->id,
            'window_id' => $response['id'],
            'status_id' => $status->id
        ]);

        $response = $this->open();

        $second_id = $response['id'];

        $this->assertTrue($first_id == $second_id);

    }

    public function test_set_free_a_window()
    {
        $user = User::findOrFail(3);

        $this->actingAs($user);

        $status = Status::where('status', 'Libre')->first();

        $response = $this->free();

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

    public function test_hangUp_a_call()
    {
        $user = User::findOrFail(2);

        $this->actingAs($user);

        $status = Status::where('status', 'En Pausa')->first();

        $array = [
            'user_id' => $user->id,
            'status_id' => $status->id,
        ];

        $response = $this->hang($array);

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

        $response = $this->close($array);

        $this->assertDatabaseHas('windows', [
            'id' => $response['id'],
            'host_id' => null,
            'client_id' => null,
            'status_id' => $status->id,
        ]);

        $this->assertDatabaseHas('traces', [
            'user_id' => $user->id,
            'window_id' => $response['id'],
            'status_id' => $status->id
        ]);

    }


}


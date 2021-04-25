<?php

namespace Tests\Feature;

use App\Http\Traits\CallTrait;
use App\Models\Call;
use App\Models\Status;
use App\Models\User;
use App\Models\Window;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class Trait_CallTest extends TestCase
{
    use DatabaseTransactions;
    use CallTrait;

    public function test_open_a_new_call()
    {
        $user = User::findOrFail(3);

        $this->actingAs($user);

        $status = Status::where('status', 'En Pausa')->first();

        $response = $this->open();

        $this->assertDatabaseHas('calls', [
            'user_id' => $user->id,
            'number' => $response->number,
            'status_id' => $status->id,
        ]);

        $this->assertDatabaseHas('traces', [
            'user_id' => $user->id,
            'call_id' => $response['id'],
            'status_id' => $status->id
        ]);

    }


    public function test_close_the_call()
    {
        $user = User::findOrFail(4);

        $call = Call::where('user_id', $user->id)->first();

        $this->actingAs($user);

        $status_closed = Status::where('status', 'Cerrado')->first();
        $status_paused = Status::where('status', 'En Pausa')->first();

        $array = [
            'id' => $call->id,
            'user_id' => $call->user_id,
            'number' => $call->number,
            'status_id' => $call->status_id,
        ];

        $window = Window::where('client_id', $user->id)->first();

        $response = $this->close($array);

        $this->assertDatabaseHas('calls', [
            'user_id' => $user->id,
            'number' => $call->id,
            'status_id' => $status_closed->id,
        ]);

        $this->assertDatabaseHas('windows', [
            'id' => $window->id,
            'client_id' => null,
            'call_id' => null,
            'status_id' => $status_paused->id,
        ]);

        $this->assertDatabaseHas('traces', [
            'user_id' => $user->id,
            'call_id' => $call->id,
            'status_id' => $status_closed->id
        ]);

    }


}


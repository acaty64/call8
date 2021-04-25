<?php

namespace Tests\Feature;

use App\Http\Traits\CallTrait;
use App\Models\Call;
use App\Models\Status;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class Trait_CallTest extends TestCase
{
    use DatabaseTransactions;
    use CallTrait;

    public function test_store_a_new_call()
    {
        $user = User::findOrFail(3);

        $this->actingAs($user);

        $status = Status::where('status', 'En Pausa')->first();

        $response = $this->store();

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

    public function test_close_a_call()
    {
        $user = User::findOrFail(4);

        $call = Call::where('user_id', $user->id)->first();

        $this->actingAs($user);

        $status = Status::where('status', 'Cerrado')->first();

        $array = [
            'id' => $call->id,
            'user_id' => $call->user_id,
            'number' => $call->number,
            'status_id' => $call->status_id,
        ];

        $response = $this->close($array);

        $this->assertDatabaseHas('calls', [
            'user_id' => $user->id,
            'number' => $call->id,
            'status_id' => $status->id,
        ]);

        $this->assertDatabaseHas('traces', [
            'user_id' => $user->id,
            'call_id' => $call->id,
            'status_id' => $status->id
        ]);

    }


}


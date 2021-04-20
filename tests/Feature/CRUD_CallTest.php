<?php

namespace Tests\Feature;

use App\Models\Call;
use App\Models\Status;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CRUD_CallTest extends TestCase
{
    use DatabaseTransactions;

    public function test_call_index_view()
    {
        $user = User::find(1);
        $this->actingAs($user);
        $response = $this->get(route('call.index'));
        $response->assertStatus(200);
        $response->assertViewIs('app.call.index');
    }

    public function test_store_a_new_call()
    {
        $user = User::create([
            'name' => 'Jane Doe',
            'code' => '22222222222',
            'email' => 'janed@gmail.com',
        ]);

        $this->actingAs($user);

        $status = Status::where('status', 'En Pausa')->first();

        $response = $this->post(route('call.store'));

        $this->assertDatabaseHas('calls', [
            'user_id' => $user->id,
            // 'number' => 4,
            'status_id' => $status->id,
        ]);

        $this->assertDatabaseHas('traces', [
            'user_id' => $user->id,
            'call_id' => $response['id'],
            'status_id' => $status->id
        ]);

        $response->assertStatus(200);
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

        $response = $this->post(route('call.close'), $array);

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


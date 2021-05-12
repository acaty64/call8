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

        $status = Status::where('status', 'En Pausa')->first();

        $this->actingAs($user);

        $response = $this->call_open(1);

        $this->assertDatabaseHas('calls', [
            'client_id' => $user->id,
            'number' => $response['number'],
            'status_id' => $status->id,
            'office_id' => 1,
        ]);

        $this->assertDatabaseHas('traces', [
            'client_id' => $user->id,
            'call_id' => $response['id'],
            'office_id' => 1,
            'status_id' => $status->id
        ]);

    }

    public function test_answer_the_call()
    {
        $host = User::findOrFail(1);

        $client = User::findOrFail(5);
        $call = Call::where('client_id', $client->id)->first();

        $window = $host->window;
        $window->host_id = $host->id;
        $window->client_id = $client->id;
        $window->call_id = $call->id;
        $window->save();

        $this->actingAs($client);

        $response = $this->call_answer($call->id);

        $status_answer = Status::where('status', 'Atendiendo')->first();

        $this->assertDatabaseHas('calls', [
            'client_id' => $client->id,
            'number' => $call->id,
            'status_id' => $status_answer->id,
        ]);

        $this->assertDatabaseHas('windows', [
            'client_id' => $client->id,
            'call_id' => $call->id,
            'status_id' => $status_answer->id,
        ]);

        $this->assertDatabaseHas('traces', [
            'client_id' => $client->id,
            'call_id' => $call->id,
            'status_id' => $status_answer->id
        ]);

    }

    public function test_close_the_call()
    {
        $host = User::findOrFail(3);
        $client = User::findOrFail(4);

        $status_answer = Status::where('status', 'Atendiendo')->first();

        $call = Call::where('client_id', $client->id)->first();
        $call->status_id = $status_answer->id;
        $call->save();

        $window = Window::find($host->id);
        $window->host_id = $host->id;
        $window->status_id = $status_answer->id;
        $window->client_id = $client->id;
        $window->call_id = $call->id;
        $window->save();

        $this->actingAs($client);

        $status_closed = Status::where('status', 'Cerrado')->first();
        $status_paused = Status::where('status', 'En Pausa')->first();

        $response = $this->call_close();

        $this->assertDatabaseHas('calls', [
            'client_id' => $client->id,
            'number' => $call->id,
            'status_id' => $status_closed->id,
        ]);

        $this->assertDatabaseHas('windows', [
            'id' => $window->id,
            'client_id' => null,
            // 'call_id' => null,
            'status_id' => $status_paused->id,
        ]);

        $this->assertDatabaseHas('traces', [
            'client_id' => $client->id,
            'call_id' => $call->id,
            'status_id' => $status_closed->id
        ]);

    }


}


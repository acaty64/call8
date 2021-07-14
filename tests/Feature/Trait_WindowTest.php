<?php

namespace Tests\Feature;

use App\Http\Traits\WindowTrait;
use App\Models\Call;
use App\Models\Schedule;
use App\Models\Status;
use App\Models\Trace;
use App\Models\User;
use App\Models\Window;
use Carbon\Carbon;
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
        $user = User::findOrFail(3);

        $this->actingAs($user);

        $status = Status::where('status', 'En Pausa')->first();

        $now = Carbon::now();
        Schedule::create([
            'office_id' => 1,
            'host_id' => $user->id,
            'day' => $now->dayOfWeek,
            'hour_start' => str_pad($now->hour, 2, "00", STR_PAD_LEFT) . ':00',
            'hour_end' => str_pad($now->hour + 1, 2, "00", STR_PAD_LEFT) . ':00',
            'date_start' => $now->subDays(2)->format('Y-m-d'),
            'date_end' => $now->addDays(2)->format('Y-m-d'),
        ]);

        $response = $this->window_open();

        $this->assertDatabaseHas('windows', [
            'host_id' => $user->id,
            'status_id' => $status->id,
            'office_id' => 1,
        ]);

        $this->assertDatabaseHas('traces', [
            'host_id' => $user->id,
            'window_id' => $response['id'],
            'status_id' => $status->id,
            'office_id' => 1,
        ]);

    }

    public function test_reopen_a_window()
    {
        $user = User::findOrFail(4);
        $this->actingAs($user);

        $now = Carbon::now();
        Schedule::create([
            'office_id' => 1,
            'host_id' => $user->id,
            'day' => $now->dayOfWeek,
            'hour_start' => str_pad($now->hour, 2, "00", STR_PAD_LEFT) . ':00',
            'hour_end' => str_pad($now->hour + 1, 2, "00", STR_PAD_LEFT) . ':00',
            'date_start' => $now->subDays(2)->format('Y-m-d'),
            'date_end' => $now->addDays(2)->format('Y-m-d'),
        ]);

        $response = $this->window_open();

        $first_id = $response['id'];

        $status = Status::where('status', 'En Pausa')->first();

        $this->assertDatabaseHas('windows', [
            'host_id' => $user->id,
            'status_id' => $status->id,
            'office_id' => 1,
        ]);

        $this->assertDatabaseHas('traces', [
            'host_id' => $user->id,
            'window_id' => $response['id'],
            'office_id' => 1,
            'status_id' => $status->id
        ]);

        $response = $this->window_open();

        $second_id = $response['id'];

        $this->assertTrue($first_id == $second_id);

    }

    public function test_set_free_a_window()
    {
        $user = User::findOrFail(3);


        $status_free = Status::where('status', 'Libre')->first();
        $status_closed = Status::where('status', 'Cerrado')->first();

        $window = Window::where('host_id', null)->first();
        $window->host_id = $user->id;
        $window->status_id = $status_closed->id;
        $window->office_id = 1;
        $window->save();

        $this->actingAs($user);

        $response = $this->window_free();

        $this->assertDatabaseHas('windows', [
            'host_id' => $user->id,
            'status_id' => $status_free->id,
            'office_id' => 1,
        ]);

        $this->assertDatabaseHas('traces', [
            'host_id' => $user->id,
            'window_id' => $response['id'],
            'office_id' => 1,
            'status_id' => $status_free->id
        ]);

    }

    public function test_start_a_call()
    {
        $status_paused = Status::where('status', 'En Pausa')->first()->id;
        $call = Call::where('status_id', $status_paused)->first();

        $user = User::findOrFail(3);

        $this->actingAs($user);

        $status = Status::where('status', 'Llamando')->first();

        $array = [
            'user_id' => $user->id,
            'status_id' => $status->id,
        ];

        $now = Carbon::now();
        Schedule::create([
            'office_id' => 1,
            'host_id' => $user->id,
            'day' => $now->dayOfWeek,
            'hour_start' => str_pad($now->hour, 2, "00", STR_PAD_LEFT) . ':00',
            'hour_end' => str_pad($now->hour + 1, 2, "00", STR_PAD_LEFT) . ':00',
            'date_start' => $now->subDays(2)->format('Y-m-d'),
            'date_end' => $now->addDays(2)->format('Y-m-d'),
        ]);

        $response = $this->window_open();
        $response = $this->window_start($array);

        $window = Window::findOrFail($user->window_id);

        $this->assertDatabaseHas('windows', [
            'host_id' => $user->id,
            'status_id' => $status->id,
            'client_id' => $call->client_id,
            'call_id' => $call->id,
        ]);

        $this->assertDatabaseHas('calls', [
            'client_id' => $call->client_id,
            'status_id' => $status->id,
        ]);

        $this->assertDatabaseHas('traces', [
            'host_id' => $user->id,
            'client_id' => $call->client_id,
            'window_id' => $window->id,
            'call_id' => $window->call_id,
            'status_id' => $status->id
        ]);

    }

    public function test_stop_a_call()
    {
        $status_answer = Status::where('status', 'Atendiendo')->first()->id;

        $call = Call::where('status_id', $status_answer)->first();

        $host = User::findOrFail(2);

        $window = Window::find($host->window_id);
        $window->status_id = $status_answer;
        $window->client_id = $call->client_id;
        $window->call_id = $call->id;
        $window->save();

        $status_closed = Status::where('status', 'Cerrado')->first();
        $status_paused = Status::where('status', 'En Pausa')->first();

        $this->actingAs($host);
        $response = $this->window_stop($host->window_id);

        $window = Window::findOrFail($host->window_id);

        $this->assertDatabaseHas('windows', [
            'host_id' => $host->id,
            'status_id' => $status_paused->id,
            'client_id' => null,
            // 'call_id' => null,
        ]);

        $this->assertDatabaseHas('calls', [
            'client_id' => $call->client_id,
            'status_id' => $status_closed->id,
        ]);

        $this->assertDatabaseHas('traces', [
            'host_id' => $host->id,
            'client_id' => $call->client_id,
            'window_id' => $window->id,
            'call_id' => $window->call_id,
            'status_id' => $status_closed->id
        ]);

    }

    public function test_paused_a_window()
    {
        $user = User::findOrFail(1);

        $this->actingAs($user);

        $status = Status::where('status', 'En Pausa')->first();

        $response = $this->window_paused();

        $this->assertDatabaseHas('windows', [
            'id' => $response['id'],
            'host_id' => $user->id,
            'client_id' => null,
            'status_id' => $status->id,
        ]);

        $this->assertDatabaseHas('traces', [
            'host_id' => $user->id,
            'window_id' => $response['id'],
            'status_id' => $status->id
        ]);

    }

    public function test_host_close_a_window()
    {
        $user = User::findOrFail(1);

        $this->actingAs($user);

        $status = Status::where('status', 'Cerrado')->first();

        $response = $this->window_out();

        $this->assertDatabaseHas('windows', [
            'id' => $response['id'],
            'host_id' => null,
            'client_id' => null,
            'status_id' => $status->id,
        ]);

        $this->assertDatabaseHas('traces', [
            'host_id' => $user->id,
            'window_id' => $response['id'],
            'status_id' => $status->id
        ]);

    }

    public function test_admin_close_a_window()
    {
        $user = User::findOrFail(1);

        $this->actingAs($user);

        $status = Status::where('status', 'Cerrado')->first();

        $host_id = $user->id;
 
        $response = $this->window_out($host_id);

        $this->assertDatabaseHas('windows', [
            'id' => $response['id'],
            'host_id' => null,
            'client_id' => null,
            'status_id' => $status->id,
        ]);

        $this->assertDatabaseHas('traces', [
            'host_id' => $user->id,
            'window_id' => $response['id'],
            'status_id' => $status->id
        ]);

    }


}


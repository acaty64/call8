<?php

namespace Tests\Feature;

use App\Models\Call;
use App\Models\Status;
use App\Models\User;
use App\Models\Window;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiTest extends TestCase
{

    use DatabaseTransactions;

    public function testOldApiStopWindow()
    {
        $status_paused = Status::where('status', 'En Pausa')->first();

        $status_closed = Status::where('status', 'Cerrado')->first();

        $host = User::find(3);
        $this->assertTrue($host->is_host);

        $client = User::find(4);
        $call = Call::where('client_id', $client->id)->first();

        $window = Window::find(1);
        $window->host_id = $host->id;
        $window->client_id = $client->id;
        $window->call_id = $call->id;
        $window->save();

        $this->actingAs($host);

        $response = $this->get('/api/stop-window/' . $window->id);

        $this->assertDatabaseHas('windows', [
            'id' => $window->id,
            'host_id' => $host->id,
            'status_id' => $status_paused->id,
        ]);

        $this->assertDatabaseHas('calls', [
            'id' => $window->call_id,
            'client_id' => $window->client_id,
            'status_id' => $status_closed->id,
        ]);

    }

    public function testApiStopWindow()
    {
        $status_paused = Status::where('status', 'En Pausa')->first();

        $status_closed = Status::where('status', 'Cerrado')->first();

        $client = User::find(7);
        $host = User::find(2);

        $call = Call::create([
            'client_id' =>$client->id,
            'number' => 9999,
            'status_id' => $status_paused->id,
            'office_id' => 1,
        ]);

        $window = Window::find(1);
        $window->host_id = $host->id;
        $window->client_id = $client->id;
        $window->call_id = $call->id;
        $window->status_id = $status_paused->id;
        $window->save();

        $this->actingAs($host);

        $response = $this->get('/api/stop-window/' . $window->id);

        $this->assertDatabaseHas('windows', [
            'id' => $window->id,
            'host_id' => $host->id,
            'status_id' => $status_paused->id,
        ]);

        $this->assertDatabaseHas('calls', [
            'id' => $window->call_id,
            'client_id' => $window->client_id,
            'status_id' => $status_closed->id,
        ]);

    }

    public function testApiGetComments()
    {
        $host = User::find(2);
        $window = Window::find(1);
        $window->client_id = 4;
        $window->save();

        $this->actingAs($host);
        $response = $this->get('/api/get-comments/' . $window->call_id);

        $this->assertNotEmpty($response->getOriginalContent()[0]);

    }

    public function testApiSaveComments()
    {
        $host = User::find(2);
        $window = Window::find(1);
        $window->host_id = $host->id;
        $window->client_id = 4;
        $window->call_id = 1;
        $window->save();

        $call = Call::find($window->call_id);
        $call->client_id = $window->client_id;
        $call->save();

        $data = [
            'host_id' => $host->id,
            'client_id' => $window->client_id,
            'call_id' => $window->call_id,
            'client_comment' => 'Client Comment Test',
            'host_comment' => 'Host Comment Test',
        ];

        // $this->actingAs($host);
        $response = $this->post('/api/save-comments/', $data);

        $this->assertTrue($response->getOriginalContent()['success']);

    }

    public function testApiSaveComments0()
    {
        $host = User::find(1);
        $window = Window::find(1);
        // $window->client_id = 4;
        // $window->save();

        $data = [
            'host_id' => $host->id,
            'client_id' => $window->client_id,
            'call_id' => $window->call_id,
            'client_comment' => 'Client Comment Test',
            'host_comment' => 'Host Comment Test',
        ];

        // $this->actingAs($host);
        $response = $this->post('/api/save-comments/', $data);

        $this->assertTrue($response->getOriginalContent()['success']);

    }




}

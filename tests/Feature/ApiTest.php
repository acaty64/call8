<?php

namespace Tests\Feature;

use App\Models\Status;
use App\Models\User;
use App\Models\Window;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiTest extends TestCase
{

    public function testApiStopWindow()
    {
        $user = User::find(1);
        $window = Window::find(1);
        $window->client_id = 4;
        $window->save();

        $this->actingAs($user);

        $response = $this->get('/api/stop-window/' . $window->id);

        $status_paused = Status::where('status', 'En Pausa')->first();

        $status_closed = Status::where('status', 'Cerrado')->first();

        $this->assertDatabaseHas('windows', [
            'id' => $window->id,
            'host_id' => $user->id,
            'status_id' => $status_paused->id,
        ]);

        $this->assertDatabaseHas('calls', [
            'id' => $window->call_id,
            'user_id' => $window->client_id,
            'status_id' => $status_closed->id,
        ]);

    }
}

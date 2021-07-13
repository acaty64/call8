<?php

namespace Tests\Feature;

use App\Models\Call;
use App\Models\Status;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CRUD_CommentTest extends TestCase
{
    use DatabaseTransactions;

    public function test_comments_index_view()
    {
        $user = User::find(1);
        $this->assertTrue($user->is_admin);
        $this->actingAs($user);
        $response = $this->get(route('comments.index'))
        		->assertStatus(200);
        $response->assertViewIs('app.comment.index');
    }

    public function test_comments_show_in_video_view()
    {
        $status_answer = Status::where('status', 'Atendiendo')->first();

        $client = User::find(5);
        $this->assertTrue($client->is_client);
        $call = Call::create([
            'number' => 999,
            'client_id' => $client->id,
            'status_id' => $status_answer->id,
            'office_id' => 1,
        ]);

        $host = User::find(2);
        $this->assertTrue($host->is_host);
        $window = $host->window;
        $window->client_id = $client->id;
        $window->call_id = $call->id;
        $window->status_id = $status_answer->id;
        $window->office_id = 1;
        $window->save();

        $route = '/video_chat/'. $host->id . '/' . $client->id . '/' . $call->id;
        $this->actingAs($host);
        $response = $this->get($route)
        		->assertStatus(200);
        // $response->assertViewIs('app.video.index');
        $response->assertViewIs('app.video.jitsi');
                // TODO Hacer VUE test
        		// ->assertSee('Consulta')
        		// ->assertSee('Respuesta');
    }


}


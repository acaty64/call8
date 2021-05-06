<?php

namespace Tests\Feature\Testing;

use App\Events\Test1Event;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class FirstTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function testLoginUserShowTestView()
    {
        $response = $this->get('/');
        $response->assertStatus(200);

        $user = User::find(1);
        $this->actingAs($user);

        $response = $this->get('/tests');
        $response->assertStatus(200);
    }

    /** @test */
    public function tests_sent_event_are_dispatched()
    {
        Event::fake([Test1Event::class]);

        $message = 'Hello';

        broadcast(new Test1Event($message));

        Event::assertDispatched(Test1Event::class, function ($e) use ($message)
        {
            // Verificacion
            return $e->message === $message;
        });
    }

    /** @test */
    public function testApiGetTest()
    {
        $user = User::find(1);
        $this->actingAs($user);
        $response = $this->get('/api/get-test');
        $this->assertTrue($response->original == ["Primer mensaje", "Segundo mensaje"]);
        $response->assertStatus(200);
    }

    /** @test */
    public function testApiPostTest()
    {
        $request = ['data' => 'Tercer mensaje'];
        Event::fake([Test1Event::class]);
        $response = $this->post(route('test.send1'), $request);
// dd($response->original);
        $this->assertTrue($response->original == "Tercer mensaje");
        $response->assertStatus(200);
    }


}
<?php

namespace Tests\Feature\Testing;

use App\Events\Test3Event;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class PresenceTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function tests_sent_presence_event_are_dispatched()
    {
        Event::fake([Test3Event::class]);

        $message = 'Hello';

        broadcast(new Test3Event($message));

        Event::assertDispatched(Test3Event::class, function ($e) use ($message)
        {
            // Verificacion
            return $e->message === $message;
        });
    }


    /** @test */
    public function testApiPostPresenceTest()
    {
        $request = ['data' => 'Tercer mensaje'];
        Event::fake([Test3Event::class]);
        $response = $this->post(route('test.send3'), $request);
// dd($response->original);
        $this->assertTrue($response->original == "Tercer mensaje");
        $response->assertStatus(200);
    }


}
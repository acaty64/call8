<?php

namespace Tests\Feature\Testing;

use App\Events\Test2Event;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class PrivateTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function tests_sent_private_event_are_dispatched()
    {
        Event::fake([Test2Event::class]);

        $message = 'Hello';

        broadcast(new Test2Event($message));

        Event::assertDispatched(Test2Event::class, function ($e) use ($message)
        {
            // Verificacion
            return $e->message === $message;
        });
    }


    /** @test */
    public function testApiPostPrivateTest()
    {
        $request = ['data' => 'Tercer mensaje'];
        Event::fake([Test2Event::class]);
        $response = $this->post(route('test.send2'), $request);
// dd($response->original);
        $this->assertTrue($response->original == "Tercer mensaje");
        $response->assertStatus(200);
    }


}
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
        $response = $this->get(route('call.index'))
        		->assertStatus(200);
        $response->assertViewIs('app.call.index');
    }


}


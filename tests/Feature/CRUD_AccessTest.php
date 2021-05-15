<?php

namespace Tests\Feature;

use App\Models\Call;
use App\Models\Status;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CRUD_AccessTest extends TestCase
{
    use DatabaseTransactions;

    public function test_access_index_view()
    {
        $user = User::find(1);
        $this->actingAs($user);
        $response = $this->get(route('access.index'))
        		->assertStatus(200);
        $response->assertViewIs('app.access.index');
    }


}


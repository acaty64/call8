<?php

namespace Tests\Feature;

use App\Models\Link;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CRUD_LinkTest extends TestCase
{
    use DatabaseTransactions;

    public function test_link_index_view()
    {
        $user = User::find(1);
        $this->actingAs($user);
        $response = $this->get(route('links.index'))
        		->assertStatus(200);
        $response->assertViewIs('app.link.index');
    }

}


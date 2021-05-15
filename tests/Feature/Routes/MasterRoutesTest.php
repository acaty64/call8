<?php

namespace Tests\Feature\Routes;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MasterRoutesTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function a_master_user_can_view_offices_screen()
    {
        $master = User::find(1);
        $this->assertTrue($master->is_master);
        $this->actingAs($master);
        $response = $this->get('/office/index');
        $response->assertStatus(200);
    }

    /** @test */
    public function non_master_user_cannot_view_offices_screen()
    {
        $admin = User::find(2);
        $this->actingAs($admin);
        $response = $this->get('/office/index');
        $response->assertStatus(403);
    }


}

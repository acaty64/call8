<?php

namespace Tests\Unit;

use App\User;
use Tests\TestCase;

class UserTest extends TestCase
{

    public function testUser()
    {
        $this->assertTrue(true);
        $this->assertDatabaseHas('users', [
	        'name' => 'Master',
            'email' => 'aarashiro@ucss.edu.pe',
	    ]);
    }
}

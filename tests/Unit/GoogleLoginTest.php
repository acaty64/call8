<?php

namespace Tests\Unit;

use App\Models\Access;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as SocialiteUser;
use Mockery as m;
use Tests\TestCase;

class GoogleLoginTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function login_request_are_send_to_google()
    {

        $abstractUser = m::mock(SocialiteUser::class);

        $message = 'Redirecting to Google...';

        $this->mockGoogleProvider()
            ->shouldReceive('redirect')
            ->andReturn($message);

    }

    /** @test */
    public function a_master_authorized_are_authenticated()
    {
        // Given ...
        $master = User::find(1);
        $this->assertTrue($master->is_master);

        $googleUser = m::mock(SocialiteUser::class, [
            'getName' => $master->name,
            'getEmail' => $master->email
        ]);

        $this->mockGoogleProvider()
            ->shouldReceive('user')
            ->andReturn($googleUser);

        // When
        $response = $this->get('/login/callback');

        // Then
        $this->assertAuthenticated();
        $response->assertRedirect(route('master.menu'));
        // $response->assertRedirect('/home');
    }

    /** @test */
    public function a_host_authorized_are_authenticated()
    {
        // Given ...
        $host = User::create([
            'name' => 'JOHN DOE',
            'given_name' => 'John',
            'email' => 'jjjjj@gmail.com',
            'code' => '999999'
        ]);

        $access = Access::create([
            'user_id' => $host->id,
            'type_id' => 3,     // Host
        ]);


        $googleUser = m::mock(SocialiteUser::class, [
            'getName' => $host->name,
            'getEmail' => $host->email
        ]);

        $this->mockGoogleProvider()
            ->shouldReceive('user')
            ->andReturn($googleUser);

        // When
        $response = $this->get('/login/callback');

        // Then
        $this->assertAuthenticated();
        $response->assertRedirect(route('call.host'));
        // $response->assertRedirect('/home');
    }

    /** @test */
    public function a_user_unauthorized_are_redirect()
    {
        // Given ...
        $user = User::create([
            'name' => 'JOHN DOE',
            'given_name' => 'John',
            'email' => 'jdoe@gmail.com',
            'code' => '999999'
        ]);

         $googleUser = m::mock(SocialiteUser::class, [
            'getName' => $user->name,
            'getEmail' => 'other@gmail.com'
        ]);

        $this->mockGoogleProvider()
            ->shouldReceive('user')
            ->andReturn($googleUser);

        // When
        $response = $this->get('home');

        // Then
        $response->assertStatus(302)
            ->assertRedirect('login');
    }



    public function mockGoogleProvider()
    {
        $provider = m::mock(GoogleProvider::class);

        Socialite::shouldReceive('driver')->with('google')->andReturn($provider);

        return $provider;
    }


}

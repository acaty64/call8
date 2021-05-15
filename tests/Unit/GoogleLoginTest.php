<?php

namespace Tests\Unit;

use App\Access;
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
    public function a_user_authorized_are_authenticated()
    {
        // Given ...
        $user = User::create([
            'name' => 'JOHN DOE',
            'email' => 'jdoe@gmail.com',
            'code' => '999999'
        ]);


        $googleUser = m::mock(SocialiteUser::class, [
            'getName' => $user->name,
            'getEmail' => $user->email
        ]);

        $this->mockGoogleProvider()
            ->shouldReceive('user')
            ->andReturn($googleUser);

        // When
        $response = $this->get('/login/callback');

        // Then
        $this->assertAuthenticated();
        $response->assertRedirect('/home');
    }

    /** @test */
    public function a_user_unauthorized_are_redirect()
    {
        // Given ...
        $user = User::create([
            'name' => 'JOHN DOE',
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

<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as SocialiteUser;
use Tests\TestCase;

class GoogleAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_google_redirect_route_works(): void
    {
        $response = $this->get('/auth/google');
        
        $response->assertRedirectContains('accounts.google.com');
    }

    public function test_google_callback_authenticates_and_creates_new_user(): void
    {
        // Mock Socialite User
        $googleUser = $this->createMock(SocialiteUser::class);
        $googleUser->method('getId')->willReturn('1234567890');
        $googleUser->method('getName')->willReturn('Google Test User');
        $googleUser->method('getNickname')->willReturn('googletest');
        $googleUser->method('getEmail')->willReturn('googletest@example.com');

        // Mock Socialite Driver
        $provider = $this->createMock(\Laravel\Socialite\Two\GoogleProvider::class);
        $provider->method('user')->willReturn($googleUser);

        // Mock Socialite Facade
        Socialite::shouldReceive('driver')
            ->with('google')
            ->andReturn($provider);

        $response = $this->get('/auth/google/callback');

        // Check user exists in database
        $this->assertDatabaseHas('users', [
            'email' => 'googletest@example.com',
            'google_id' => '1234567890',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/dashboard');
    }

    public function test_google_callback_authenticates_existing_user(): void
    {
        $user = User::factory()->create([
            'email' => 'googletest@example.com',
            'google_id' => null,
        ]);

        // Mock Socialite User
        $googleUser = $this->createMock(SocialiteUser::class);
        $googleUser->method('getId')->willReturn('1234567890');
        $googleUser->method('getName')->willReturn('Google Test User');
        $googleUser->method('getNickname')->willReturn('googletest');
        $googleUser->method('getEmail')->willReturn('googletest@example.com');

        // Mock Socialite Driver
        $provider = $this->createMock(\Laravel\Socialite\Two\GoogleProvider::class);
        $provider->method('user')->willReturn($googleUser);

        // Mock Socialite Facade
        Socialite::shouldReceive('driver')
            ->with('google')
            ->andReturn($provider);

        $response = $this->get('/auth/google/callback');

        // Check user exists in database with updated google_id
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'email' => 'googletest@example.com',
            'google_id' => '1234567890',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/dashboard');
    }
}

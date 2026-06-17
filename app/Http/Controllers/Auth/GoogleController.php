<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Exception;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google and log them in.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Get avatar URL from Google
            $avatar = $googleUser->getAvatar();
            
            // 1. Check if user already logged in with Google before
            $user = User::where('google_id', $googleUser->getId())->first();
            
            if ($user) {
                // Make sure user is active if that field exists
                if (method_exists($user, 'isActive') && !$user->isActive()) {
                    return redirect()->route('login')->withErrors([
                        'email' => 'Akun Anda sedang ditangguhkan.',
                    ]);
                }
                
                // Update avatar in case it changed
                if ($avatar) {
                    $user->update(['avatar' => $avatar]);
                }
                
                Auth::login($user);
                return redirect()->intended('/dashboard');
            }

            // 2. Check if a user with the same email already exists
            $existingUser = User::where('email', $googleUser->getEmail())->first();
            
            if ($existingUser) {
                // Link Google ID to existing email
                $existingUser->update([
                    'google_id' => $googleUser->getId(),
                    'avatar' => $avatar,
                ]);
                
                if (method_exists($existingUser, 'isActive') && !$existingUser->isActive()) {
                    return redirect()->route('login')->withErrors([
                        'email' => 'Akun Anda sedang ditangguhkan.',
                    ]);
                }
                
                Auth::login($existingUser);
                return redirect()->intended('/dashboard');
            }

            // 3. Create a new user
            $newUser = User::create([
                'name' => $googleUser->getName() ?? $googleUser->getNickname() ?? 'Google User',
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'avatar' => $avatar,
                'password' => null,
                'role' => 'user',
            ]);

            // Set email_verified_at if column exists
            $newUser->email_verified_at = now();
            $newUser->save();

            Auth::login($newUser);
            return redirect('/dashboard');

        } catch (Exception $e) {
            return redirect()->route('login')->withErrors([
                'email' => 'Gagal login menggunakan Google. Silakan coba lagi. (' . $e->getMessage() . ')',
            ]);
        }
    }
}

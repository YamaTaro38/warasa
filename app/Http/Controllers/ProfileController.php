<?php
// app/Http/Controllers/ProfileController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\User;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'name' => 'required|string|max:255',
        ];

        if ($request->has('email') && $request->email !== null) {
            $rules['email'] = 'required|email|unique:users,email,' . $user->id;
        }

        $request->validate($rules);

        $user->name = $request->name;

        if ($request->has('email') && $request->email !== null && $user->email !== $request->email) {
            $oldEmail = $user->email;
            $newEmail = $request->email;

            $user->email = $newEmail;

            if ($user->hasVerifiedEmail()) {
                $user->email_verified_at = null;
                $user->save();

                $user->sendEmailVerificationNotification();

                return back()->with('warning', 'Email changed! Please verify your new email address. A verification link has been sent to ' . $newEmail);
            } else {
                $user->save();

                $user->sendEmailVerificationNotification();

                return back()->with('warning', 'Email changed! A verification link has been sent to ' . $newEmail);
            }
        }

        $user->save();

        return back()->with('success', 'Profile updated successfully!');
    }

    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $user = Auth::user();

        // Delete old avatar if it exists and is a local upload (not Google URL)
        if ($user->avatar && !str_contains($user->avatar, 'googleusercontent.com')) {
            $oldRelativePath = str_replace(asset('storage') . '/', '', $user->avatar);
            if (Storage::disk('public')->exists($oldRelativePath)) {
                Storage::disk('public')->delete($oldRelativePath);
            }
        }

        // Upload new avatar
        $image = $request->file('avatar');
        $filename = 'avatars/' . $user->id . '/' . Str::random(20) . '.' . $image->getClientOriginalExtension();
        
        // Store directly to the 'public' disk (storage/app/public/)
        Storage::disk('public')->put($filename, file_get_contents($image));

        $avatarUrl = asset('storage/' . $filename);

        $user->update(['avatar' => $avatarUrl]);

        return back()->with('success', 'Foto profil berhasil diperbarui!');
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();
        
        $rules = [
            'password' => 'required|min:8|confirmed',
        ];
        
        if (!$user->google_id || $user->password) {
            $rules['current_password'] = 'required|current_password';
        }
        
        $request->validate($rules);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password updated successfully!');
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();
        Auth::logout();
        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Your account has been deleted successfully.');
    }

    public function resendVerification(Request $request)
    {
        try {
            $user = $request->user();

            Log::info('Resend verification requested for user: ' . $user->email);

            if ($user->hasVerifiedEmail()) {
                Log::warning('User already verified: ' . $user->email);
                if ($request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Email already verified.'
                    ], 400);
                }
                return back()->with('error', 'Email already verified.');
            }

            $user->sendEmailVerificationNotification();

            Log::info('Verification email resent successfully to: ' . $user->email);

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Verification link has been sent to ' . $user->email
                ], 200);
            }

            return back()->with('success', 'Verification link has been sent to ' . $user->email);
        } catch (\Exception $e) {
            Log::error('Error sending verification email: ' . $e->getMessage());
            Log::error($e->getTraceAsString());

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to send verification email. Error: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Failed to send verification email. Please try again later.');
        }
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\VerificationEmail;
use App\Mail\ResetPasswordEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    
     //Register a new user
    
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Generate 8-character verification token (uppercase letters and numbers)
        $verificationToken = strtoupper(Str::random(8));
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'email_verification_token' => $verificationToken,
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        // Send verification email
        try {
            Mail::to($user->email)->send(new VerificationEmail($user, $verificationToken));
        } catch (\Exception $e) {
            \Log::error('Failed to send verification email: ' . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => 'User registered successfully. Please check your email to verify your account.',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'email_verified' => false,
                'phone' => $user->phone,
                'address' => $user->address,
                'city' => $user->city,
                'state' => $user->state,
                'pincode' => $user->pincode,
            ],
            'token' => $token,
            'verification_token' => $verificationToken, // For testing/display - remove in production
        ], 201);
    }

    
     //Login user
    
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        // Delete old tokens
        $user->tokens()->delete();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'email_verified' => $user->email_verified_at !== null,
                'phone' => $user->phone,
                'address' => $user->address,
                'city' => $user->city,
                'state' => $user->state,
                'pincode' => $user->pincode,
            ],
            'token' => $token,
        ]);
    }

    
      //Logout user
     
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully',
        ]);
    }

    
     // Get authenticated user
     
    public function user(Request $request)
    {
        $user = $request->user();
        return response()->json([
            'success' => true,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'email_verified' => $user->email_verified_at !== null,
                'phone' => $user->phone,
                'address' => $user->address,
                'city' => $user->city,
                'state' => $user->state,
                'pincode' => $user->pincode,
            ],
        ]);
    }

    
     // Password reset request
     
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        // Generate 8-character reset token (uppercase letters and numbers)
        $token = strtoupper(Str::random(8));
        
        // Store token in database (hashed for security)
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'email' => $request->email,
                'token' => Hash::make($token),
                'created_at' => now(),
            ]
          );

        // Send password reset email
        $user = User::where('email', $request->email)->first();
        try {
            Mail::to($request->email)->send(new ResetPasswordEmail($user, $token));
        } catch (\Exception $e) {
            \Log::error('Failed to send password reset email: ' . $e->getMessage());
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Password reset link sent to your email. Please check your inbox.',
            'reset_token' => $token, // For testing only - remove in production
        ]);
    }


     // Reset password

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:6|confirmed',
            'token' => 'required|string',
        ]);

        // Find the reset token
        $resetRecord = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$resetRecord) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid reset token',
            ], 404);
        }

        // Verify token
        if (!Hash::check($request->token, $resetRecord->token)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid reset token',
            ], 400);
        }

        // Check if token is expired (24 hours)
        if (now()->diffInHours($resetRecord->created_at) > 24) {
            return response()->json([
                'success' => false,
                'message' => 'Reset token has expired',
            ], 400);
        }

        // Update password
        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        // Delete the reset token
        DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->delete();

        return response()->json([
            'success' => true,
            'message' => 'Password reset successfully',
        ]);
    }

    /**
     * Verify email with token
     */
    public function verifyEmail(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
        ]);

        $user = User::where('email_verification_token', $request->token)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid verification token',
            ], 404);
        }

        if ($user->email_verified_at) {
            return response()->json([
                'success' => true,
                'message' => 'Email already verified',
            ]);
        }

        $user->email_verified_at = now();
        $user->email_verification_token = null;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Email verified successfully',
        ]);
    }

    /**
     * Resend verification email
     */
    public function resendVerification(Request $request)
    {
        $user = $request->user();

        if ($user->email_verified_at) {
            return response()->json([
                'success' => false,
                'message' => 'Email already verified',
            ], 400);
        }

        // Generate new 8-character token (uppercase letters and numbers)
        $verificationToken = strtoupper(Str::random(8));
        $user->email_verification_token = $verificationToken;
        $user->save();

        // Send verification email
        try {
            Mail::to($user->email)->send(new VerificationEmail($user, $verificationToken));
        } catch (\Exception $e) {
            \Log::error('Failed to resend verification email: ' . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => 'Verification email sent. Please check your inbox.',
            'verification_token' => $verificationToken, // For testing - remove in production
        ]);
    }

    // Update user profile
    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'pincode' => 'nullable|string|max:10',
        ]);

        $user->update($validated);

        // If address fields are provided, sync with addresses table
        if (!empty($validated['address']) || !empty($validated['city']) || !empty($validated['state']) || !empty($validated['pincode'])) {
            // Find or create a "Profile Address" entry
            $profileAddress = $user->addresses()->where('label', 'Profile Address')->first();
            
            $addressData = [
                'label' => 'Profile Address',
                'street' => $validated['address'] ?? '',
                'city' => $validated['city'] ?? '',
                'state' => $validated['state'] ?? '',
                'zip' => $validated['pincode'] ?? '',
                'country' => 'India',
            ];

            if ($profileAddress) {
                // Update existing profile address
                $profileAddress->update($addressData);
            } else {
                // Create new profile address and set as default if no other addresses exist
                $addressData['is_default'] = $user->addresses()->count() === 0;
                $user->addresses()->create($addressData);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully',
            'user' => $user->fresh(),
        ]);
    }

    /**
     * Redirect to Google OAuth
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    /**
     * Handle Google OAuth callback
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
            
            // Find or create user
            $user = User::where('email', $googleUser->email)->first();
            
            if ($user) {
                // Update existing user with Google info
                $user->update([
                    'google_id' => $googleUser->id,
                    'avatar' => $googleUser->avatar,
                    'provider' => 'google',
                    'email_verified_at' => $user->email_verified_at ?? now(), // Auto-verify if not already
                ]);
            } else {
                // Create new user
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'avatar' => $googleUser->avatar,
                    'provider' => 'google',
                    'email_verified_at' => now(), // Google emails are pre-verified
                    'password' => Hash::make(uniqid()), // Random password
                ]);
            }
            
            // Create token
            $token = $user->createToken('auth_token')->plainTextToken;
            
            // Redirect to frontend with token
            $frontendUrl = env('FRONTEND_URL', 'http://localhost:5173');
            return redirect()->away("{$frontendUrl}/auth/google/callback?token={$token}");
            
        } catch (\Exception $e) {
            \Log::error('Google OAuth error: ' . $e->getMessage());
            $frontendUrl = env('FRONTEND_URL', 'http://localhost:5173');
            return redirect()->away("{$frontendUrl}/login?error=oauth_failed");
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Mail\OtpVerificationMail;
use App\Mail\PasswordResetMail;
use App\Models\User;
use App\Models\Profile;
use App\Models\UserRole;
use App\Models\Subscription;
use App\Models\Referral;
use App\Models\UserLog;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required_without:firm_name|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
           
        ]);

        $name = $request->name ?? $request->firm_name ?? $request->email;

        $user = User::create([
            'name' => $name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Profile::create([
            'user_id' => $user->id,
            'email' => $user->email,
            'full_name' => $name,
            'phone_number' => $request->phone,
            
        ]);

        UserRole::create([
            'user_id' => $user->id,
            'role' => 'user',
        ]);

       

      

        $otpCode = $this->assignOtp($user);

        $this->sendWelcomeEmail($user, $otpCode);

        return response()->json([
            'success' => true,
            'message' => 'Verification code sent to your email address.',
            'data' => [
                'email' => $user->email,
            ],
        ], 201);
    }

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

        if (!$user->hasVerifiedEmail()) {
            $otpCode = $this->assignOtp($user);
            $emailSent = $this->sendWelcomeEmail($user, $otpCode);

            $message = $emailSent
                ? 'Verify your account with the code sent to your email.'
                : 'Failed to send verification code. Please try again or contact support.';

            throw ValidationException::withMessages([
                'email' => [$message],
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        UserLog::create([
            'user_id' => $user->id,
            'action' => 'login',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'device' => $this->getDevice($request->userAgent()),
            'location' => 'Unknown', // Placeholder for now
        ]);

        return response()->json([
            'success' => true,
            'data' => [
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => $user->load(['profile', 'roles']),
            ],
        ]);
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        
        UserLog::create([
            'user_id' => $user->id,
            'action' => 'logout',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'device' => $this->getDevice($request->userAgent()),
            'location' => 'Unknown', // Placeholder for now
        ]);

        $user->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully',
        ]);
    }

    public function user(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'success' => true,
            'data' => $user->load(['profile', 'roles']),
        ]);
    }

    public function forgotPassword(Request $request)
    {
        if ($request->isMethod('get')) {
            Log::warning('GET request to forgot-password', [
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'referer' => $request->header('referer'),
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Please use a POST request to this endpoint.',
            ], 405);
        }

        return $this->sendPasswordResetEmail($request);
    }

    public function sendPasswordResetEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();

        $token = $user->createToken('password_reset', ['password-reset'], now()->addMinutes(30))->plainTextToken;

        try {
            Mail::to($user->email)->send(new PasswordResetMail($user, config('app.frontend_url') . '/reset-password?token=' . $token));

            return response()->json([
                'success' => true,
                'message' => 'Password reset email sent successfully',
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send password reset email: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to send password reset email. Please try again later.',
            ], 500);
        }
    }

    public function resetPassword(Request $request)
    {
        $data = $request->validate([
            'token' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $token = PersonalAccessToken::findToken($data['token']);

        if (!$token || $token->name !== 'password_reset' || ($token->expires_at && now()->greaterThan($token->expires_at))) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired token',
            ], 400);
        }

        $user = $token->tokenable;

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid token',
            ], 400);
        }

        $user->forceFill([
            'password' => Hash::make($data['password']),
        ])->save();

        $token->delete();

        return response()->json([
            'success' => true,
            'message' => 'Password updated successfully',
        ]);
    }

    public function changePassword(Request $request)
    {
        $data = $request->validate([
            'current_password' => 'required|string',
            'new_password' => ['required', 'string', Password::min(8), 'confirmed'],
        ]);

        $user = $request->user();

        if (!Hash::check($data['current_password'], $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => ['Current password is incorrect.'],
            ]);
        }

        $user->forceFill([
            'password' => Hash::make($data['new_password']),
        ])->save();

        return response()->json([
            'success' => true,
            'message' => 'Password updated successfully',
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'code' => 'required|string|size:5',
        ]);

        $user = User::where('email', $data['email'])->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'code' => ['Invalid verification code.'],
            ]);
        }

        if ($user->email_verified_at) {
            $token = $this->issueSanctumToken($user);

            return response()->json([
                'success' => true,
                'data' => [
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                    'user' => $user->load(['profile', 'roles']),
                ],
            ]);
        }

        if (!$user->otp_code || !$user->otp_expires_at || now()->greaterThan($user->otp_expires_at)) {
            throw ValidationException::withMessages([
                'code' => ['Verification code has expired. Request a new code.'],
            ]);
        }

        if ($data['code'] !== $user->otp_code) {
            $attempts = ($user->otp_attempts ?? 0) + 1;

            $user->forceFill([
                'otp_attempts' => $attempts,
            ])->save();

            $message = $attempts >= 5 ? 'Too many incorrect attempts. Request a new code.' : 'Invalid verification code.';

            throw ValidationException::withMessages([
                'code' => [$message],
            ]);
        }

        $user->forceFill([
            'email_verified_at' => now(),
            'otp_verified_at' => now(),
            'otp_code' => null,
            'otp_expires_at' => null,
            'otp_attempts' => 0,
        ])->save();

        event(new Verified($user));

        $token = $this->issueSanctumToken($user);

        UserLog::create([
            'user_id' => $user->id,
            'action' => 'login',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'device' => $this->getDevice($request->userAgent()),
            'location' => 'Unknown', // Placeholder for now
        ]);

        return response()->json([
            'success' => true,
            'data' => [
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => $user->load(['profile', 'roles']),
            ],
        ]);
    }

    public function resendOtp(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $data['email'])->first();

        if (!$user) {
            return response()->json([
                'success' => true,
                'message' => 'If the email exists, a new verification code has been sent.',
            ]);
        }

        if ($user->email_verified_at) {
            return response()->json([
                'success' => true,
                'message' => 'Account already verified.',
            ]);
        }

        $otpCode = $this->assignOtp($user);

        $emailSent = $this->sendWelcomeEmail($user, $otpCode);

        return response()->json([
            'success' => $emailSent,
            'message' => $emailSent
                ? 'Verification code resent.'
                : 'Failed to resend verification code. Please try again or contact support.',
        ]);
    }

    public function destroy(Request $request)
    {
        $data = $request->validate([
            'password' => 'required|string',
        ]);

        $user = $request->user();

        if (!Hash::check($data['password'], $user->password)) {
            throw ValidationException::withMessages([
                'password' => ['Incorrect password.'],
            ]);
        }

        $user->tokens()->delete();

        if ($user->profile) {
            $user->profile->delete();
        }

        $user->roles()->delete();
        $user->subscriptions()->delete();

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Account deleted successfully',
        ]);
    }

    private function getDevice($userAgent): string
    {
        if (empty($userAgent)) {
            return 'Unknown';
        }

        $os = 'Unknown OS';
        $browser = 'Unknown Browser';

        // OS Detection
        if (preg_match('/windows|win32/i', $userAgent)) {
            $os = 'Windows';
        } elseif (preg_match('/macintosh|mac os x/i', $userAgent)) {
            $os = 'Mac OS';
        } elseif (preg_match('/linux/i', $userAgent)) {
            $os = 'Linux';
        } elseif (preg_match('/iphone/i', $userAgent)) {
            $os = 'iPhone';
        } elseif (preg_match('/android/i', $userAgent)) {
            $os = 'Android';
        }

        // Browser Detection
        if (preg_match('/MSIE/i', $userAgent) && !preg_match('/Opera/i', $userAgent)) {
            $browser = 'Internet Explorer';
        } elseif (preg_match('/Firefox/i', $userAgent)) {
            $browser = 'Firefox';
        } elseif (preg_match('/Chrome/i', $userAgent)) {
            $browser = 'Chrome';
        } elseif (preg_match('/Safari/i', $userAgent)) {
            $browser = 'Safari';
        } elseif (preg_match('/Opera/i', $userAgent)) {
            $browser = 'Opera';
        } elseif (preg_match('/Netscape/i', $userAgent)) {
            $browser = 'Netscape';
        }

        return $os . ' (' . $browser . ')';
    }

    private function assignOtp(User $user): string
    {
        $code = str_pad((string) random_int(0, 99999), 5, '0', STR_PAD_LEFT);

        $user->forceFill([
            'otp_code' => $code,
            'otp_expires_at' => now()->addMinutes(10),
            'otp_attempts' => 0,
            'otp_verified_at' => null,
        ])->save();

        return $code;
    }

    private function sendWelcomeEmail($user, string $otpCode): bool
    {
        try {
            Mail::to($user->email)->send(new OtpVerificationMail($user, $otpCode, config('app.frontend_url')));
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to send welcome email: ' . $e->getMessage());
            return false;
        }
    }

    public function verifyEmail(Request $request, $id, $hash)
    {
        if (!URL::hasValidSignature($request)) {
            abort(403);
        }

        $user = User::findOrFail($id);

        if (!hash_equals(sha1($user->getEmailForVerification()), (string) $hash)) {
            abort(403);
        }

        if (!$user->hasVerifiedEmail() && $user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        $user->forceFill([
            'otp_code' => null,
            'otp_expires_at' => null,
            'otp_attempts' => 0,
            'otp_verified_at' => now(),
        ])->save();

        $token = $this->issueSanctumToken($user);

        return $this->verifiedResponse($user, $token);
    }

    private function issueSanctumToken(User $user): string
    {
        $user->tokens()->where('name', 'auth_token')->delete();

        return $user->createToken('auth_token')->plainTextToken;
    }

    private function verifiedResponse(User $user, string $token)
    {
        $redirectUrl = rtrim(config('app.frontend_url'), '/');

        $query = http_build_query([
            'token' => $token,
            'email' => $user->email,
        ]);

        return redirect()->away($redirectUrl . '/?' . $query);
    }
}

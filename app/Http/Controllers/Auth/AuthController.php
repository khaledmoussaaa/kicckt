<?php

namespace App\Http\Controllers\Auth;

// Controller
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgetPassword;

// Requests
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\ResetPassword;

// Illuminate
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Password;

// Models
use App\Models\User;

class AuthController extends Controller
{
    // Get a JWT via given credentials.
    public function login(LoginRequest $request)
    {
        $token = auth()->attempt($request->validated());
        if (!$token) {
            return messageResponse('Email or Password in correct..', false, 401);
        }
        return authResponse($token, 'Login Successfully');
    }

    // Get a JWT via given registred.
    public function register(RegisterRequest $request)
    {
        $user = User::create($request->validated());
        if ($request->hasFile('media')) {
            $user->addMediaFromRequest('media')->toMediaCollection('avatar');
        }
        $token = auth()->login($user);
        return authResponse($token, 'Register Successfully');
    }

    // Get the authenticated User.
    public function me()
    {
        return contentResponse(auth()->user());
    }

    // Log the user out (Invalidate the token).
    public function logout()
    {
        auth()->logout();
        return messageResponse('Logged out successfully');
    }

    // Forget Password
    public function forgetPassowrd(ForgetPassword $request)
    {
        $status = Password::sendResetLink($request->validated());
        return $status === Password::RESET_LINK_SENT ? messageResponse('Reset link send successfully') : messageResponse('Failed, To many request, try again after 1 minute', false, 429);
    }

    // Reset Password
    public function resetPassword(ResetPassword $request)
    {
        $status = Password::reset($request->validated(), function (User $user, string $password) {
            $user->forceFill(['password' => $password])->save();
            event(new PasswordReset($user));
        });
        return $status === Password::PASSWORD_RESET ? messageResponse('Password reseted successfully') : messageResponse('Failed, Url is expired..', false, 403);
    }

    // Refresh a token.
    public function refresh()
    {
        return contentResponse(auth()->refresh());
    }

    // Get a token by id
    public function blockedUser(User $user)
    {
        try {
            $user->delete();
            return messageResponse();
        } catch (\Throwable $error) {
            return messageResponse($error->getMessage(), false, 403);
        }
    }
}

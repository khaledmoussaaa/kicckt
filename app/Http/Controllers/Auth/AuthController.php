<?php

namespace App\Http\Controllers\Auth;

// Controller
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\BlockRequest;
// Requests
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\ProfileRequest;
// Models
use App\Models\User;

class AuthController extends Controller
{
    // Get a JWT via given credentials.
    public function login(LoginRequest $request)
    {
        $user = User::firstOrCreate($request->validated());
        $token = auth()->login($user);
        return authResponse($token, $user->wasRecentlyCreated);
    }

    // Get a JWT via given registred.
    public function profile(ProfileRequest $request)
    {
        $user = auth_user()->update($request->validated());
        if ($request->hasFile('media')) {
            $user->addMediaFromRequest('media')->toMediaCollection('avatar');
        }
        return messageResponse();
    }

    // Get the authenticated User.
    public function me()
    {
        return contentResponse(array_merge(auth()->user()->load('media')->toArray(), ['is_new' => auth_user()->wasRecentlyCreated]));
    }

    // Refresh a token.
    public function refresh()
    {
        return contentResponse(auth()->refresh());
    }

    // Block Or Unblock User
    public function blocked(BlockRequest $request)
    {
        $user = User::withTrashed()->find($request->validated('user_id'));
        $blocked = $user->deleted_at ? 'User Unblocked' : 'User Blocked';
        $user->deleted_at ? $user->restore() : $user->delete();
        return messageResponse($blocked);
    }

    // Logout the user (Invalidate the token).
    public function logout()
    {
        auth()->logout();
        return messageResponse('Logged out successfully');
    }
}

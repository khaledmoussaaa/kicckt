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
        if (!$user->hasRole('superadmin')) {
            $user->syncRoles(['user']);
        }
        return authResponse($token, $user->wasRecentlyCreated);
    }

    // Get a JWT via given registred.
    public function profile(ProfileRequest $request)
    {
        $user = auth_user()->update($request->validated());
        add_media(auth_user(), $request, 'avatar');
        return messageResponse();
    }

    // Get the authenticated User.
    public function me()
    {
        return contentResponse(auth()->user()->load('media')->toArray() + ['is_new' => auth_user()->wasRecentlyCreated, 'role' => auth_user()->roles[0]->name ?? 'user']);
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
        $blocked = $user->blocked ? 'User Unblocked' : 'User Blocked';
        $user->update(['blocked' => $user->blocked ? 0 : 1]);
        return messageResponse($blocked);
    }

    // Logout the user (Invalidate the token).
    public function logout()
    {
        auth()->logout();
        return messageResponse('Logged out successfully');
    }
}

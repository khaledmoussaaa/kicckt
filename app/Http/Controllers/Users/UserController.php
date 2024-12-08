<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\UserRequest;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::withTrashed()->with('media')->paginate(10);
        $users->transform(function ($user) {
            $user->blocked = $user->deleted_at ? true : false;
            return $user;
        });
        return contentResponse($users);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::withTrashed()->find($id);
        return contentResponse($user->load('media'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request)
    {
        auth_user()->update($request->validated());
        if ($request->hasFile('media')) {
            auth_user()->addMediaFromRequest('media')->toMediaCollection('avatar');
        }
        return messageResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->forceDelete();
        return messageResponse();
    }
}
<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('media')->paginate(11);
        return contentResponse($users);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return contentResponse($user->load('media'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request)
    {
        auth_user()->update($request->validated());
        if($request->hasFile('media')){
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

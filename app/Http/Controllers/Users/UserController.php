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
    public function index(Request $request)
    {
        $query = User::query();
    
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }
        if ($request->type == 'blocks') {
            $query->withTrashed();
        }
        $users = $query->with('media')->paginate(10);
        if ($request->type == 'blocks') {
            $users->getCollection()->transform(function ($user) {
                $user->blocked = $user->deleted_at ? true : false;
                return $user;
            });
        }
    
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

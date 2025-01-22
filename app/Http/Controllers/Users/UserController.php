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
            $query->onlyTrashed();
        }
        $users = $query->with('media')->paginate(10);
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
        add_media(auth_user(), $request, 'avatar');
        return messageResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->update(['deleted' => 1]);
        $user->delete();
        return messageResponse();
    }
}

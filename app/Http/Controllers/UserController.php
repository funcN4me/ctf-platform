<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Models\User;

class UserController extends Controller
{
    public function show()
    {
        $users = User::all();
        return view('users', compact('users'));
    }

    public function profile($id)
    {
        $user = User::find($id);
        return view('user', compact('user'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->name = $request->name;
        $user->group = $request->group;
        $user->email = $request->email;
        if (!$user->save()) {
            return abort(500);
        }
        return back()->with(['success' => 'Успешно']);
    }
}

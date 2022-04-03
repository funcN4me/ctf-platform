<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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
}

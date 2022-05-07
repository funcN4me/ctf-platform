<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::user()->isAdmin()) {
            $tasks = Task::count();
            $users = User::count();
            $resources = Resource::count();

            return view('home', compact('tasks', 'users', 'resources'));
        }
        return view('home');
    }
}

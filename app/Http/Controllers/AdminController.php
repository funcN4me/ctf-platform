<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('isAdmin');
    }

    public function index()
    {
        $tasks = Task::all();
        $users = User::all();
        $resources = Resource::all();

        return view('admin.index', compact('tasks', 'resources'));
    }
}

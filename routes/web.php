<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::post('/register', [RegisterController::class, 'create'])->name('register');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');


Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/tasks', [TaskController::class, 'show'])->name('tasks.show')->middleware('auth');
Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create')->middleware('isAdmin');
Route::post('/tasks/create', [TaskController::class, 'store'])->name('tasks.store')->middleware('isAdmin');

Route::post('/tasks/check', [TaskController::class, 'check'])->name('tasks.check');
Route::get('/task/{id}', [TaskController::class, 'get'])->name('task.get');
Route::get('/task/attachment/{name}', [TaskController::class, 'download'])->name('task.download');

Route::get('/users', [UserController::class, 'show'])->name('users.show');
Route::get('/user/{id}', [UserController::class, 'profile'])->name('user.profile');

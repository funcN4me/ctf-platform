<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EducationController;

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

Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/tasks', [TaskController::class, 'show'])->name('tasks.show')->middleware('auth');
Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create')->middleware('isAdmin');
Route::post('/tasks/create', [TaskController::class, 'store'])->name('tasks.store')->middleware('isAdmin');

Route::post('/tasks/check', [TaskController::class, 'check'])->name('tasks.check')->middleware('auth');
Route::get('/task/{id}', [TaskController::class, 'get'])->name('task.get')->middleware('auth');
Route::get('/task/attachment/{name}', [TaskController::class, 'download'])->middleware('auth')->name('task.download');
Route::delete('/task/attachment/{attachment}', [TaskController::class, 'deleteAttachment'])->middleware('isAdmin')->name('task.deleteAttachment');
Route::delete('/task/{task}', [TaskController::class, 'delete'])->name('task.delete')->middleware('isAdmin');
Route::get('/task/edit/{task}', [TaskController::class, 'edit'])->name('task.edit')->middleware('isAdmin');
Route::put('/task/edit/{task}', [TaskController::class, 'update'])->name('task.update')->middleware('isAdmin');

Route::get('/users', [UserController::class, 'show'])->name('users.show')->middleware('isAdmin');
Route::get('/user/{id}', [UserController::class, 'profile'])->name('user.profile')->middleware('auth');
Route::put('/user/{user}', [UserController::class, 'update'])->name('user.update')->middleware('isAdmin');

Route::get('/education', [EducationController::class, 'index'])->name('education.show')->middleware('auth');
Route::get('/education/{resource}', [EducationController::class, 'show'])->name('resource.show')->middleware('auth');
Route::get('/education/edit/{resource}', [EducationController::class, 'showEdit'])->name('resource.showEdit')->middleware(['auth', 'isAdmin']);
Route::put('/education/edit/{resource}', [EducationController::class, 'edit'])->name('resource.edit')->middleware(['auth', 'isAdmin']);
Route::delete('/education/{resource}', [EducationController::class, 'delete'])->name('resource.delete')->middleware('isAdmin');

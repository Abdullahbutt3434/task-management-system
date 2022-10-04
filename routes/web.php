<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Models\Task;
use Illuminate\Support\Facades\Route;

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
Route::get('registration', [AuthController::class, 'registration'])->name('register');
Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post');
Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post');

Route::middleware(['auth'])->group(
    function () {
        Route::get('dashboard', [AuthController::class, 'dashboard']);
        Route::get('logout', [AuthController::class, 'logout'])->name('logout');


        // users rotues
        Route::name('users.')->group(
            function () {
                Route::get('users', [UserController::class, 'index'])->name('list');
            }
        );
        // Task rotues
        Route::name('tasks.')->group(
            function () {
                Route::get('tasks', [TaskController::class, 'index'])->name('list');
                Route::get('add-task', [TaskController::class, 'create'])->name('create');
                Route::post('tasks', [TaskController::class, 'store'])->name('store');
                Route::get('task/{id}', [TaskController::class, 'edit'])->name('edit');
                Route::put('task', [TaskController::class, 'update'])->name('update');
                Route::post('delete', [TaskController::class, 'destory'])->name('destory');

                // task assigned to me 
                Route::get('my-task', [TaskController::class, 'myTasks'])->name('myTasks');
            }
        );
    }
);

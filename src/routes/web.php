<?php

use App\Enums\TaskStatus;
use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Http\Controllers\AuthController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
   Route::get('/login', [AuthController::class, 'showLogin']);
   Route::post('/login', [AuthController::class, 'login'])->name('login');

   Route::get('/register', [AuthController::class, 'showRegister']);
   Route::post('/register', [AuthController::class, 'register'])->name('register');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', function () {
    $user = Auth::user();
    $data = [];
    if ($user->role === UserRole::TEACHER){
        //fetch all student that are pending
        $data['pendingStudents'] = User::where('status', UserStatus::PENDING)->get();
    } else {
        //fetch tasks for logging student
        $data['myTasks'] = $user->tasks()->where('status', '!=', TaskStatus::DONE)->get();
    }
    return view('dashboard', $data);

})->middleware('auth')->name('dashboard');

<?php

use App\Enums\TaskStatus;
use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TeacherController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
   Route::get('/login', [AuthController::class, 'showLogin']);
   Route::post('/login', [AuthController::class, 'login'])->name('login');

   Route::get('/register', [AuthController::class, 'showRegister']);
   Route::post('/register', [AuthController::class, 'register'])->name('register');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/dashboard', function () {
    $user = Auth::user();
    $data = [];
    if ($user->role === UserRole::TEACHER){
        //fetch all student that are pending
        $data['pendingStudents'] = User::where('status', UserStatus::PENDING)->get();
        $data['projects'] = $user->managedProject()->get();
    } else {
        //fetch tasks for logging student
        $data['myTasks'] = $user->tasks()->where('status', '!=', TaskStatus::DONE)->get();
    }
    return view('dashboard.index', $data);

})->middleware('auth')->name('dashboard');

Route::middleware(['auth'])->group(function (){
    Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
    Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');

    Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
});

Route::middleware(['auth'])->prefix('teacher')->name('teacher.')->group(function (){
   Route::post('/student/{student}/approve', [TeacherController::class, 'approveStudent'])->name('student.approve');
   Route::post('/invite/store', [TeacherController::class, 'storeInvitation'])->name('invite.store');

});

Route::get('/register/{token}', [AuthController::class, 'showRegister'])->name('register.invite');

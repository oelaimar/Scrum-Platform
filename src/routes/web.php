<?php

use App\Enums\TaskStatus;
use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RetrospectiveController;
use App\Http\Controllers\SprintController;
use App\Http\Controllers\StandupController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TeacherController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
   Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
   Route::post('/login', [AuthController::class, 'login'])->name('login.store');

   Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
   Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

use App\Http\Controllers\DashboardController;

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

Route::middleware(['auth'])->group(function (){
    Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
    Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');

    Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');

    Route::get('/projects/{project}/sprints/create', [SprintController::class, 'create'])->name('sprints.create');
    Route::post('/projects/{project}/sprints', [SprintController::class, 'store'])->name('sprints.store');

    Route::get('/sprints/{sprint}/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
    Route::post('/sprints/{sprint}/tasks', [TaskController::class, 'store'])->name('tasks.store');

    Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
    Route::put('/tasks/{task}/progress', [TaskController::class, 'updateProgress'])->name('tasks.progress.update');

    Route::put('/tasks/{task}/evaluate/{student}', [TaskController::class, 'evaluate'])->name('tasks.evaluate');

    Route::get('/sprints/{sprint}/standups/create', [StandupController::class, 'create'])->name('standups.create');
    Route::post('/sprints/{sprint}/standups', [StandupController::class, 'store'])->name('standups.store');

    Route::get('/sprints/{sprint}/standups', [StandupController::class, 'index'])->name('standups.index');

    Route::patch('/sprints/{sprint}/start', [SprintController::class, 'start'])->name('sprints.start');
    Route::patch('/sprints/{sprint}/complete', [SprintController::class, 'complete'])->name('sprints.complete');

    Route::get('/sprints/{sprint}/retrospective/create', [RetrospectiveController::class, 'create'])->name('retrospectives.create');
    Route::post('/sprints/{sprint}/retrospective', [RetrospectiveController::class, 'store'])->name('retrospectives.store');
    Route::get('/sprints/{sprint}/retrospectives', [RetrospectiveController::class, 'index'])->name('retrospectives.index');

    Route::post('/projects/{project}/students', [ProjectController::class, 'addStudent'])->name('projects.addStudent');
    Route::delete('/projects/{project}/students/{student}', [ProjectController::class, 'removeStudent'])->name('projects.removeStudent');
});

Route::middleware(['auth'])->prefix('teacher')->name('teacher.')->group(function (){
   Route::get('/students', [TeacherController::class, 'studentsIndex'])->name('students.index');
   Route::post('/student/{student}/approve', [TeacherController::class, 'approveStudent'])->name('student.approve');
});

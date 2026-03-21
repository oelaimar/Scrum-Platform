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

   Route::get('/register/{token}', [AuthController::class, 'showRegister'])->name('register.invite');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/dashboard', function () {
    /** @var \App\Models\User $user */
    $user = Auth::user();
    $data = [];
    if ($user->role === UserRole::TEACHER){
        //fetch all student that are pending
        $data['pendingStudents'] = User::where('status', UserStatus::PENDING)->get();
        $data['projects'] = $user->managedProject()->get();
    } elseif ($user->role === UserRole::ADMIN) {
        $data['totalUsers'] = User::count();
        $data['pendingStudents'] = User::where('status', UserStatus::PENDING)->get();
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

    Route::patch('/sprints/{sprint}/complete', [SprintController::class, 'complete'])->name('sprints.complete');

    Route::get('/sprints/{sprint}/retrospective/create', [RetrospectiveController::class, 'create'])->name('retrospectives.create');
    Route::post('/sprints/{sprint}/retrospective', [RetrospectiveController::class, 'store'])->name('retrospectives.store');
    Route::get('/sprints/{sprint}/retrospectives', [RetrospectiveController::class, 'index'])->name('retrospectives.index');
});

Route::middleware(['auth'])->prefix('teacher')->name('teacher.')->group(function (){
   Route::post('/student/{student}/approve', [TeacherController::class, 'approveStudent'])->name('student.approve');
   Route::post('/invite/store', [TeacherController::class, 'storeInvitation'])->name('invite.store');

});


<?php

namespace App\Http\Controllers;

use App\Enums\TaskStatus;
use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the user's dashboard based on their role.
     */
    public function index(): View
    {
        /** @var User $user */
        $user = Auth::user();
        $data = [];

        if ($user->role === UserRole::TEACHER) {
            $data = $this->teacherDashboard($user);
        } elseif ($user->role === UserRole::ADMIN) {
            $data = $this->adminDashboard();
        } else {
            $data = $this->studentDashboard($user);
        }

        return view('dashboard.index', $data);
    }
    private function teacherDashboard(User $teacher): array
    {
        return [
            'pendingStudents' => User::where('status', UserStatus::PENDING)->get(),
            'projects' => $teacher->managedProjects()->with(['sprints', 'students'])->get(),
        ];
    }
    private function adminDashboard(): array
    {
        return [
            'totalUsers' => User::count(),
            'pendingStudents' => User::where('status', UserStatus::PENDING)->get(),
        ];
    }
    private function studentDashboard(User $student): array
    {
        return [
            'taskProgress' => $student->taskProgress()
                ->where('status', '!=', \App\Enums\TaskStatus::DONE->value)
                ->with(['task.sprint.project'])
                ->get(),
            'projects' => $student->projects()->with(['activeSprint', 'sprints.tasks'])->get(),
        ];
    }
}

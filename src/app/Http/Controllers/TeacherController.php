<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Http\Requests\InviteStudentRequest;
use App\Models\Invitation;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class TeacherController extends Controller
{
    public function studentsIndex()
    {
        if (Auth::user()->role !== UserRole::TEACHER) abort(403);
        
        $students = User::where('role', UserRole::STUDENT)
            ->withCount('projects')
            ->orderBy('status', 'asc') // Pending first
            ->orderBy('name', 'asc')
            ->get();
            
        return view('students.index', compact('students'));
    }

    public function approveStudent(User $student)
    {
        if (Auth::user()->role !== UserRole::TEACHER){
            abort(403, 'Unauthorized action.');
        }
        if ($student->status === UserStatus::PENDING){
            // Security: Check if student belongs to any of this teacher's projects
            $isTheirStudent = Auth::user()->managedProjects()
                ->whereHas('students', function($q) use ($student) {
                    $q->where('users.id', $student->id);
                })->exists();

            // Also allow approving students who signed up manually and haven't been assigned to a project yet
            $isOrphan = $student->projects()->count() === 0;

            if (!$isTheirStudent && !$isOrphan) {
                return back()->with('error', 'You can only approve students assigned to your projects or new manual signups.');
            }

            $student->status = UserStatus::ACTIVE;
            $student->save();

            return back()->with('success', 'Student ' . $student->name . ' has been approved.');
        }
        return back()->with('error', 'Student is not pending approval or already active.');
    }
}

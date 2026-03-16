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
    public function approveStudent(User $student)
    {
        if (Auth::user()->role !== UserRole::TEACHER){
            abort(403, 'Unauthorized action.');
        }
        if ($student->status === UserStatus::PENDING){
            $student->status = UserStatus::ACTIVE->value;
            $student->save();

            return back()->with('success', 'student ' . $student->name . 'has been approved.');
        }
        return back()->with('error', 'Student is not pending approval or already active.');
    }
    public function showProjectInvites(Project $project)
    {
        //is teacher own this project?
        if($project->teacher_id !== Auth::id()){
            abort(403,'You are not authorized to view invites for this project.');
        }
        $invitations = $project->invitations()->where('is_used', false)->get();
        return view('teacher.project_invites', compact('project', 'invitations'));
    }
    public function storeInvitation(InviteStudentRequest $request)
    {
        $token = Str::random(32);
        $invitation = Invitation::create([
            'project_id' => $request->project_id,
            'email' => $request->email,
            'token' => $token,
            'expires_at' => now()->addDay(2),
        ]);
        $registrationLink = URL::temporarySignedRoute(
            'register.invite',
            now()->addMinute(60),
            ['token' => $token, 'email' => $request->email],
        );
        //we still not using email the register link will appear in message
        return back()->with('success', 'Invitation link generated! Share this with the student: ' . $registrationLink);
    }
}

<?php

namespace Database\Seeders;

use App\Enums\ProjectStatus;
use App\Enums\SprintStatus;
use App\Enums\TaskStatus;
use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Models\Project;
use App\Models\Sprint;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ScrumPlatformSeeder extends Seeder
{
    public function run(): void
    {
        $teacher = User::create([
            'name' => 'Prof Aziz',
            'email' => 'aziz@gmail.com',
            'password' => Hash::make('password'),
            'role' => UserRole::TEACHER->value,
            'status' => UserStatus::ACTIVE->value,
        ]);
        $students = [];
        for($i = 0; $i < 5; $i++){
            $students[] = User::create([
                'name' => "Student {$i}",
                'email' => "student{$i}@scrum.com",
                'password' => Hash::make('password'),
                'role' => UserRole::STUDENT->value,
                'status' => UserStatus::ACTIVE->value,
            ]);
        }
        $project = Project::create([
            'name' => 'java script project',
            'description' => 'Building single page landing page',
            'teacher_id' => $teacher->id,
            'status' => ProjectStatus::ACTIVE->value,
        ]);
        //Enroll students into project
        foreach ($students as $student) $project->students()->attach($student->id);
        $sprint = Sprint::create([
            'project_id' => $project->id,
            'name' => 'Sprint 1: js learning basic',
            'objective' => 'learn the data type',
            'start_date' => now(),
            'end_date' => now()->addDay(7),
            'status' => SprintStatus::ACTIVE->value,
        ]);
        $tasks = [
            ['title' => 'declare the integer', 'point' => 3],
            ['title' => 'declare the float', 'point' => 2],
            ['title' => 'declare the array', 'point' => 1],
        ];
        foreach ($tasks as $taskData) {
            $task = Task::create([
                'sprint_id' => $sprint->id,
                'title' => $taskData['title'],
                'story_points' => $taskData['point'],
            ]);
            foreach ($students as $student) {
                $task->students()->attach($student->id, ['status' => TaskStatus::TODO->value,]);
            }
        }
    }
}

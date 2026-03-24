<?php

namespace App\Http\Requests;

use App\Enums\TaskStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateTaskProgressRequest extends FormRequest
{
    public function authorize(): bool
    {
        $task = $this->route('task');
        $user = $this->user();
        return $user->isStudent() && $user->tasks()->where('tasks.id', $task->id)->exists();
    }
    public function rules(): array
    {
        return [
            'status' => new Enum(TaskStatus::class),
            'solution_link' => ['nullable', 'url', 'max:1000'],
        ];
    }
}

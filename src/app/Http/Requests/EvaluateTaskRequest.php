<?php

namespace App\Http\Requests;

use App\Enums\TaskStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class EvaluateTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isTeacher();
    }
    public function rules(): array
    {
        return [
            'status' => ['required', new Enum(TaskStatus::class)],
            'teacher_feedback' => ['nullable', 'string', 'max:1000'],
        ];
    }
}

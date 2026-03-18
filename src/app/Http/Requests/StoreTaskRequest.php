<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        $sprint = $this->route('sprint');
        return $this->user()->isTeacher() &&
            $sprint->project->teacher_id === $this->user()->id;
    }
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'story_points' => ['required', 'integer', 'min:1'],
        ];
    }
}

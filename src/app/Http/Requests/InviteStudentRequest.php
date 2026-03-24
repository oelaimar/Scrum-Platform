<?php

namespace App\Http\Requests;

use App\Enums\UserRole;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class InviteStudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() && $this->user()->role  === UserRole::TEACHER;
    }
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users', 'unique:invitations,email,NULL,id,is_used,0'],
            'project_id' => ['required', 'exists:projects,id']
        ];
    }
    public function messages()
    {
        return [
            'email.unique' => 'A user with this email already exists in the system',
        ];
    }
}

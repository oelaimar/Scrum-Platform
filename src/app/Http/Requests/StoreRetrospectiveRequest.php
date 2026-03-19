<?php

namespace App\Http\Requests;

use App\Enums\SprintStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreRetrospectiveRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = $this->user();
        $sprint = $this->route('sprint');
        return $user->isStudent() &&
            $sprint->status === SprintStatus::COMPLETED &&
            $user->projects->contains($sprint->project_id);
    }
    public function rules(): array
    {
        return [
            'positives' => ['required', 'string'],
            'difficulties' => ['required', 'string'],
            'improvements' => ['required', 'string'],
        ];
    }
    public function messages(): array
    {
        return [
            'positives.required' => 'Please tell us what went well.',
            'difficulties.required' => 'Please describe the challenges you faced.',
            'improvements.required' => 'Please suggest at least one improvement.',
        ];
    }
}

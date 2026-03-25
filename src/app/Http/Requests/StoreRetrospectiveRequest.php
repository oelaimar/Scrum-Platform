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
            $user->projects->contains('id', $sprint->project_id);
    }
    public function rules(): array
    {
        return [
            'what_went_well' => ['required', 'string'],
            'what_needs_improvement' => ['required', 'string'],
            'action_items' => ['required', 'string'],
        ];
    }
    public function messages(): array
    {
        return [
            'what_went_well.required' => 'Please tell us what went well.',
            'what_needs_improvement.required' => 'Please describe what needs improvement.',
            'action_items.required' => 'Please suggest action items.',
        ];
    }
}

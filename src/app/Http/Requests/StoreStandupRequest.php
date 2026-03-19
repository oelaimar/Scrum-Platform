<?php

namespace App\Http\Requests;

use App\Enums\SprintStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreStandupRequest extends FormRequest
{
    public function authorize(): bool
    {
        $sprint = $this->route('sprint');
        return $this->user()->isStudent() &&
                $this->user()->projects->contains($sprint->project) &&
                $sprint->status === SprintStatus::ACTIVE;
    }
    public function rules(): array
    {
        return [
            'work_done' => ['required', 'string', 'max:1000'],
            'work_planned' => ['required', 'string', 'max:1000'],
            'blockers' => ['nullable', 'string', 'max:1000'],
        ];
    }
}

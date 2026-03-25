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
            'did_yesterday' => ['required', 'string', 'max:1000'],
            'will_do_today' => ['required', 'string', 'max:1000'],
            'blockers' => ['nullable', 'string', 'max:1000'],
        ];
    }
}

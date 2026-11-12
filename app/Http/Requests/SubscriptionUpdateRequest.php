<?php

namespace App\Http\Requests;

use App\Models\Subscription;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/** Admin: change the status / term of a subscription. */
class SubscriptionUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => ['required', Rule::in(array_keys(Subscription::STATUSES))],
            'starts_at' => ['nullable', 'date'],
            'ends_at' => ['nullable', 'date', 'after_or_equal:starts_at'],
        ];
    }

    public function attributes(): array
    {
        return [
            'starts_at' => 'start date',
            'ends_at' => 'end date',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'starts_at' => $this->filled('starts_at') ? $this->starts_at : null,
            'ends_at' => $this->filled('ends_at') ? $this->ends_at : null,
        ]);
    }
}

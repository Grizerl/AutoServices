<?php

namespace App\Http\Requests;

use App\Models\Repair;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/** Admin: update a repair request. */
class RepairRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:60'],
            'phone' => ['required', 'string', 'regex:'.ContactRequest::PHONE_REGEX],
            'car' => ['required', 'string', 'max:100'],
            'problem' => ['required', 'string', 'max:500'],
            'price' => ['required', 'integer', 'min:0', 'max:10000000'],
            'done' => ['required', Rule::in(array_keys(Repair::STATUSES))],
        ];
    }

    public function messages(): array
    {
        return [
            'phone.regex' => 'Please enter a valid phone number, for example +380 95 066 09 59.',
        ];
    }

    public function attributes(): array
    {
        return [
            'problem' => 'problem description',
            'done' => 'status',
        ];
    }
}

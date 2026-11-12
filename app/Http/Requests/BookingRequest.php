<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/** Public "Get in touch" form on the home page that creates a repair request. */
class BookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:60'],
            'phone' => ['required', 'string', 'regex:'.ContactRequest::PHONE_REGEX],
            'car' => ['required', 'string', 'min:2', 'max:100'],
            'comment' => ['required', 'string', 'min:6', 'max:500'],
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
            'comment' => 'problem description',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'name' => is_string($this->name) ? trim($this->name) : $this->name,
            'phone' => is_string($this->phone) ? trim($this->phone) : $this->phone,
        ]);
    }

    /** Return the visitor to the form after a validation error. */
    protected function getRedirectUrl(): string
    {
        return route('home_auto').'#contacts';
    }
}

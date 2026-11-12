<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/** Public "Ask a question" form on the contacts page. */
class ContactRequest extends FormRequest
{
    /** Digits, spaces, dashes, brackets and an optional leading plus (7-20 chars). */
    public const PHONE_REGEX = '/^\+?[0-9][0-9\s\-\(\)]{6,19}$/';

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:60'],
            'phone' => ['required', 'string', 'regex:'.self::PHONE_REGEX],
            'email' => ['nullable', 'email:rfc', 'max:255'],
            'message' => ['required', 'string', 'min:5', 'max:1000'],
            'consent' => ['accepted'],
        ];
    }

    public function messages(): array
    {
        return [
            'phone.regex' => 'Please enter a valid phone number, for example +380 95 066 09 59.',
            'consent.accepted' => 'Please agree to the processing of personal data.',
        ];
    }

    protected function getRedirectUrl(): string
    {
        return route('contacts').'#ask-question';
    }
}

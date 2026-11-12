<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/** Public: "Request this car" form on the car page. */
class CarInquiryRequest extends FormRequest
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
            'email' => ['nullable', 'email:rfc', 'max:255'],
            'message' => ['nullable', 'string', 'max:1000'],
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
        return route('car.show', $this->route('car')).'#request';
    }
}

<?php

namespace App\Http\Requests;

use App\Models\Subscription;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/** Public: checkout form for a subscription plan. */
class SubscribeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'billing_period' => ['required', Rule::in(array_keys(Subscription::PERIODS))],
            'name' => ['required', 'string', 'min:2', 'max:60'],
            'phone' => ['required', 'string', 'regex:'.ContactRequest::PHONE_REGEX],
            'email' => ['nullable', 'email:rfc', 'max:255'],
            'car' => ['required', 'string', 'min:2', 'max:120'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'consent' => ['accepted'],
        ];
    }

    public function messages(): array
    {
        return [
            'phone.regex' => 'Please enter a valid phone number, for example +380 95 066 09 59.',
            'consent.accepted' => 'Please agree to the processing of personal data.',
            'billing_period.in' => 'Please choose monthly or yearly billing.',
        ];
    }

    public function attributes(): array
    {
        return [
            'car' => 'car',
            'billing_period' => 'billing period',
        ];
    }

    protected function getRedirectUrl(): string
    {
        return route('plan.checkout', ['plan' => $this->route('plan'), 'period' => $this->input('billing_period')]).'#checkout';
    }
}

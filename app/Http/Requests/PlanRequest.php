<?php

namespace App\Http\Requests;

use App\Models\SubscriptionPlan;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

/** Admin: create / update a subscription plan. */
class PlanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $plan = $this->route('plan'); // null when creating

        return [
            'name' => ['required', 'string', 'max:60'],
            'slug' => ['required', 'string', 'max:80', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/', Rule::unique('subscription_plans', 'slug')->ignore($plan)],
            'description' => ['nullable', 'string', 'max:255'],
            'icon' => ['required', Rule::in(array_keys(SubscriptionPlan::ICONS))],
            'price_monthly' => ['required', 'integer', 'min:1', 'max:100000'],
            'price_yearly' => ['nullable', 'integer', 'min:1', 'max:1000000'],
            'features' => ['required', 'string', 'max:2000'],
            'excluded_features' => ['nullable', 'string', 'max:2000'],
            'is_popular' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:65000'],
        ];
    }

    public function messages(): array
    {
        return [
            'slug.regex' => 'The slug may only contain lowercase letters, numbers and single dashes.',
        ];
    }

    public function attributes(): array
    {
        return [
            'price_monthly' => 'monthly price',
            'price_yearly' => 'yearly price',
            'excluded_features' => 'not included list',
            'features' => 'included features',
            'sort_order' => 'sort order',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'slug' => Str::slug($this->input('slug') ?: (string) $this->input('name')),
            'price_yearly' => $this->filled('price_yearly') ? $this->price_yearly : null,
            'is_popular' => $this->boolean('is_popular'),
            'is_active' => $this->boolean('is_active'),
            'sort_order' => $this->filled('sort_order') ? $this->sort_order : 0,
        ]);
    }
}

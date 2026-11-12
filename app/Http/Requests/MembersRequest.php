<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/** Admin: team member. The photo is an uploaded file, not a link. */
class MembersRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $imageRules = ['image', 'mimes:jpg,jpeg,png,webp', 'max:2048'];

        return [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'regex:'.ContactRequest::PHONE_REGEX],
            'age' => ['required', 'integer', 'between:16,80'],
            'residence' => ['required', 'string', 'max:255'],
            'role' => ['required', 'string', 'max:255'],
            'image' => $this->isMethod('post')
                ? array_merge(['required'], $imageRules)
                : array_merge(['nullable'], $imageRules),
        ];
    }

    public function messages(): array
    {
        return [
            'phone.regex' => 'Please enter a valid phone number, for example +380 95 066 09 59.',
            'image.max' => 'The photo must not be larger than 2 MB.',
            'image.mimes' => 'The photo must be a JPG, PNG or WebP image.',
        ];
    }

    public function attributes(): array
    {
        return [
            'residence' => 'place of residence',
            'image' => 'photo',
        ];
    }
}

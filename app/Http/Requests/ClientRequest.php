<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/** Admin: customer testimonial. */
class ClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'role' => ['required', 'string', 'max:255'],
            'commentars' => ['required', 'string', 'max:1000'],
        ];
    }

    public function attributes(): array
    {
        return [
            'role' => 'role / car',
            'commentars' => 'comment',
        ];
    }
}

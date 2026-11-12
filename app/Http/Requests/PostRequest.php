<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/** Admin: blog / about-us post. */
class PostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'content_post' => ['required', 'string', 'max:5000'],
        ];
    }

    public function attributes(): array
    {
        return [
            'content_post' => 'content',
        ];
    }
}

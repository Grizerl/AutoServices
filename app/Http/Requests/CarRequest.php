<?php

namespace App\Http\Requests;

use App\Models\Car;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/** Admin: create / update a car for sale. The photo is an uploaded file. */
class CarRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $image = ['image', 'mimes:jpg,jpeg,png,webp', 'max:4096'];

        return [
            'brand' => ['required', 'string', 'max:60'],
            'model' => ['required', 'string', 'max:80'],
            'year' => ['required', 'integer', 'between:1980,'.(now()->year + 1)],
            'mileage' => ['required', 'integer', 'min:0', 'max:2000000'],
            'price' => ['required', 'integer', 'min:1', 'max:10000000'],
            'old_price' => ['nullable', 'integer', 'min:1', 'max:10000000', 'gt:price'],
            'fuel' => ['required', Rule::in(array_keys(Car::FUELS))],
            'transmission' => ['required', Rule::in(array_keys(Car::TRANSMISSIONS))],
            'color' => ['nullable', 'string', 'max:40'],
            'description' => ['nullable', 'string', 'max:3000'],
            'status' => ['required', Rule::in(array_keys(Car::STATUSES))],
            'is_featured' => ['nullable', 'boolean'],
            'image' => $this->isMethod('post')
                ? array_merge(['required'], $image)
                : array_merge(['nullable'], $image),
        ];
    }

    public function messages(): array
    {
        return [
            'old_price.gt' => 'The old price must be higher than the current price (it is shown crossed out).',
            'image.max' => 'The photo must not be larger than 4 MB.',
            'image.mimes' => 'The photo must be a JPG, PNG or WebP image.',
        ];
    }

    public function attributes(): array
    {
        return [
            'old_price' => 'old price',
            'image' => 'photo',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'old_price' => $this->filled('old_price') ? $this->old_price : null,
            'is_featured' => $this->boolean('is_featured'),
        ]);
    }
}

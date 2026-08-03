<?php

namespace App\Http\Requests\Api\Brand;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBrandRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
{
    return [
        'name.en' => [
            'sometimes',
            'string',
            'max:255',
        ],

        'name.ar' => [
            'sometimes',
            'string',
            'max:255',
        ],
'slug' => [
    'sometimes',
    'string',
    Rule::unique('brands', 'slug')->ignore($this->route('id')),
],
        'logo' => [
            'nullable',
            'image',
            'mimes:jpg,jpeg,png,webp',
            'max:2048',
        ],
    ];

}
}

<?php

namespace App\Http\Requests\Api\Category;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
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
            'name.en'=>[ 'bail','required','string','max:255'],
            'name.ar'=>[ 'bail','nullable','string','max:255'],
            'parent_id'=>[ 'bail','nullable','exists:categories,id'],
            'images'=>[ 'bail','nullable','image','mimes:jpg,jpeg,png,webp','max:2048'],
            'status'=>[ 'bail','boolean','nullable']
        ];
    }
}

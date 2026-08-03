<?php

namespace App\Http\Requests\Api\Admin\Product;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ProductFilterRequest extends FormRequest
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
            'search' => ['nullable', 'string', 'max:255'],

            'category' => ['nullable'],
            'category.*' => 'exists:categories,id',

            'brand' => ['nullable'],
            'brand.*' => 'exists:brands,id',

            'status' => ['nullable', 'boolean'],

            'featured' => ['nullable', 'boolean'],

            'sort' => 'nullable|in:price,-price,name,-name,created_at,-created_at,stock_quantity,-stock_quantity,top_rated',
            'min_price' => [
                    'nullable',
                    'numeric',
                    'min:0'
                ],
            'max_price' => ['nullable', 'numeric', 'gte:min_price'],
            
            'per_page' => [
                'nullable',
                'integer',
                'min:1',
                'max:100'
            ]
        ];
    }
}

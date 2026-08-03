<?php

namespace App\Http\Requests\Api\Admin\Product;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
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
            'name'=>['required','array'],
            'name.en'=>['sometimes','string','max:255'],
            'name.ar'=>['nullable','string','max:255'],

            'description'=>['nullable','array'],
            'description.en'=>['nullable','string'],
            'description.ar'=>['nullable','string'],

            'short_description' => ['nullable', 'array'],
            'short_description.en' => ['nullable', 'string'],
            'short_description.ar' => ['nullable', 'string'],

            'category_id' => ['sometimes', 'exists:categories,id'],
            'brand_id' => ['sometimes', 'exists:brands,id'],

            'price' => ['sometimes', 'numeric', 'min:0'],
            'sale_price' => ['nullable', 'numeric', 'min:0', 'lte:price'],

            'sku' => ['sometimes', 'string', 'max:255',Rule::unique('products','sku')->ignore($this->route('product'))],

            'gender' => ['sometimes', 'string', 'max:50'],

            'is_featured' => ['sometimes', 'boolean'],
            'is_bestseller' => ['sometimes', 'boolean'],
            'status' => ['sometimes', 'boolean'],

            'stock_quantity' => ['sometimes', 'integer', 'min:0'],
            'low_stock_threshold' => ['sometimes', 'integer', 'min:0'],

            'is_out_of_stock' => ['sometimes', 'boolean'],

            'images' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }
}

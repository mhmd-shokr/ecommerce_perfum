<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
    
            // Translatable fields (JSON)
            'name.en' => 'required|string|max:255',
            'name.ar' => 'required|string|max:255',
    
            'description.en' => 'nullable|string',
            'description.ar' => 'nullable|string',
    
            'short_description.en' => 'nullable|string|max:255',
            'short_description.ar' => 'nullable|string|max:255',
    
            'slug' => 'nullable|string|unique:products,slug',
    
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
    
            'sku' => 'required|string|unique:products,sku',
    
            'stock' => 'required|integer|min:0',
    
            'gender' => 'required|in:Men,Women,Unisex,Kids',
    
            'is_featured' => 'boolean',
            'is_bestseller' => 'boolean',
            'status' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'category_id.required' => 'القسم مطلوب',
            'brand_id.required' => 'الماركة مطلوبة',
            'name.en.required' => 'اسم المنتج بالإنجليزية مطلوب',
            'name.ar.required' => 'اسم المنتج بالعربية مطلوب',
            'price.required' => 'سعر البيع مطلوب',
            'price.gt' => 'سعر البيع يجب أن يكون أكبر من سعر الشراء',
            'purchase_price.required' => 'سعر الشراء مطلوب',
            'sku.required' => 'رمز SKU مطلوب',
            'sku.unique' => 'رمز SKU موجود مسبقاً',
            'stock_quantity.required' => 'الكمية مطلوبة',
            'gender.required' => 'الجنس المستهدف مطلوب',
            'image.image' => 'يجب أن يكون الملف صورة',
        ];
    }
}

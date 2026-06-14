<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'name.en'=>['required','string','max:255'],
            'name.ar'=>['required','string','max:255'],
            'parent_id'=>['nullable','exists:categories,id'],
        ];
    }
    public function messages(): array
    {
        return [
            'name.en.required' => 'اسم القسم بالإنجليزية مطلوب',
            'name.ar.required' => 'اسم القسم بالعربية مطلوب',
            'parent_id.exists' => 'القسم الأب المختار غير موجود',
            // 'image.image' => 'يجب أن يكون الملف صورة',
            // 'image.max' => 'حجم الصورة يجب ألا يتجاوز 2 ميجابايت',
        ];
    }
}

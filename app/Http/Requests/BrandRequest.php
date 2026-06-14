<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class BrandRequest extends FormRequest
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
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'اسم الماركة مطلوب',
            'name.unique' => 'اسم الماركة موجود مسبقاً',
            'logo.image' => 'يجب أن يكون الشعار صورة',
            'logo.max' => 'حجم الشعار يجب ألا يتجاوز 2 ميجابايت',
        ];
    }
}

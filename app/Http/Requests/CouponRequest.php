<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CouponRequest extends FormRequest
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
    {     $couponId = $this->route('coupon');
        return [
            'code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('coupons', 'code')->ignore($couponId),
            ],
            'type'        => 'required|in:fixed,percent',
            'value'       => 'required|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'expires_at'  => 'nullable|date|after:today',
            'is_active'   => 'boolean',
        ];
    }
}

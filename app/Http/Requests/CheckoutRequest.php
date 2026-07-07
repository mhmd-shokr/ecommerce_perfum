<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
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
        $hasAddress = !empty($this->address_id);
    
        return [
            'address_id'  => 'nullable|exists:addresses,id',
            'full_name'   => $hasAddress ? 'nullable' : 'required|string|max:100',
            'phone'       => $hasAddress ? 'nullable' : 'required|string|max:20',
            'governorate' => $hasAddress ? 'nullable' : 'required|string|max:100',
            'city'        => $hasAddress ? 'nullable' : 'required|string|max:100',
            'street'      => $hasAddress ? 'nullable' : 'required|string|max:255',
            'building'    => 'nullable|string|max:50',
            'floor'       => 'nullable|string|max:50',
            'notes'       => 'nullable|string|max:500',
            'payment_method' => 'required|in:cash,stripe',
            'coupon_code' => 'nullable|string|max:50',
        ];
    }
}

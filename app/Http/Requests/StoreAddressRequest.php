<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreAddressRequest extends FormRequest
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
            'full_name'   => ['required', 'string', 'max:255'],
            'phone'       => ['required', 'string', 'max:20'],
            'governorate' => ['required', 'string', 'max:100'],
            'city'        => ['required', 'string', 'max:100'],
            'street'      => ['required', 'string', 'max:255'],
            'building'    => ['nullable', 'string', 'max:50'],
            'floor'       => ['nullable', 'string', 'max:50'],
            'notes'       => ['nullable', 'string', 'max:500'],
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSupplierRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'supplier_name' => 'sometimes|string|max:255',
            'contact_person' => 'sometimes|string|max:255',
            'phone_number' => 'sometimes|string|max:20',
            'email' => 'sometimes|email|max:255',
            'address' => 'sometimes|string',
            'supplier_type' => 'sometimes|string|in:Feed,Medicine,Equipment',
            'products_supplied' => 'sometimes|string',
            'payment_terms' => 'sometimes|string|in:Cash,Credit',
            'status' => 'sometimes|string|in:Active,Inactive',
            'remarks' => 'nullable|string',
        ];
    }
}

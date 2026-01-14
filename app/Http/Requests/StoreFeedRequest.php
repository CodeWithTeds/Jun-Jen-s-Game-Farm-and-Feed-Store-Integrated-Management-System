<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFeedRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'feed_name' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048', // 2MB Max
            'feed_type' => 'required|string|in:Starter,Grower,Finisher,Breeder',
            'brand' => 'required|string|max:255',
            'quantity' => 'required|numeric|min:0',
            'unit' => 'required|string|in:Sack,Kg',
            'batch_number' => 'required|string|max:255',
            'expiration_date' => 'required|date',
            'supplier' => 'required|string|max:255',
            'date_received' => 'required|date',
            'reorder_level' => 'required|integer|min:0',
            'storage_location' => 'required|string|in:Warehouse,Feed room',
            'status' => 'required|string|in:Available,Low Stock,Expired',
            'is_displayed' => 'sometimes|boolean',
            'remarks' => 'nullable|string',
        ];
    }
}

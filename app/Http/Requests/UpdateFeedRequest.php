<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFeedRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'feed_name' => 'sometimes|string|max:255',
            'image' => ['nullable', 'image', 'max:2048'], // 2MB Max
            'feed_type' => 'sometimes|string|in:Starter,Grower,Finisher,Breeder,Supplement,Farm Product',
            'brand' => 'sometimes|string|max:255',
            'quantity' => 'sometimes|numeric|min:0',
            'price' => 'sometimes|numeric|min:0',
            'unit' => 'sometimes|string|in:Sack,Kg',
            'batch_number' => 'sometimes|string|max:255',
            'expiration_date' => 'sometimes|date',
            'supplier' => 'sometimes|string|max:255',
            'date_received' => 'sometimes|date',
            'reorder_level' => 'sometimes|integer|min:0',
            'storage_location' => 'sometimes|string|in:Warehouse,Feed room',
            'status' => 'sometimes|string|in:Available,Low Stock,Expired',
            'is_displayed' => 'sometimes|boolean',
            'remarks' => 'nullable|string',
        ];
    }
}

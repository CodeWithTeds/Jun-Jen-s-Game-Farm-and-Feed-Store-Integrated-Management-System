<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFeedUsageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'feed_id' => ['required', 'exists:feeds,id'],
            'chick_rearing_id' => ['required', 'exists:chick_rearings,id'],
            'used_date' => ['required', 'date'],
            'quantity' => ['required', 'numeric', 'min:0'],
            'remarks' => ['nullable', 'string'],
        ];
    }
}

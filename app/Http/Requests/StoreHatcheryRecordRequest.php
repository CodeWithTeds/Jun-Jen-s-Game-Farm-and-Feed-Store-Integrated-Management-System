<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreHatcheryRecordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'egg_collection_id' => 'required|exists:egg_collections,id',
            'incubator_id' => 'required|string',
            'temperature' => 'required|numeric',
            'humidity' => 'required|numeric',
            'turning_schedule' => 'required|string',
            'candling_date' => 'nullable|date',
            'fertility_rate' => 'nullable|numeric',
            'hatch_rate' => 'nullable|numeric',
            'hatch_result' => 'nullable|string',
            'remarks' => 'nullable|string',
        ];
    }
}

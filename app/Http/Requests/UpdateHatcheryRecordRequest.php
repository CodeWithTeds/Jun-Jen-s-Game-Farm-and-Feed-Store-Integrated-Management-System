<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHatcheryRecordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'egg_collection_id' => 'sometimes|exists:egg_collections,id',
            'incubator_id' => 'sometimes|string',
            'temperature' => 'sometimes|numeric',
            'humidity' => 'sometimes|numeric',
            'turning_schedule' => 'sometimes|string',
            'candling_date' => 'nullable|date',
            'fertility_rate' => 'nullable|numeric',
            'hatch_rate' => 'nullable|numeric',
            'hatch_result' => 'nullable|string',
            'remarks' => 'nullable|string',
        ];
    }
}

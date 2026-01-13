<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEggCollectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'collection_date' => 'sometimes|date',
            'dam_id' => 'sometimes|exists:game_fowls,id',
            'sire_id' => 'sometimes|exists:game_fowls,id',
            'egg_count' => 'sometimes|integer|min:1',
            'egg_condition' => 'sometimes|string',
            'collection_staff' => 'sometimes|string',
            'storage_location' => 'sometimes|string',
            'incubation_start_date' => 'nullable|date',
            'expected_hatch_date' => 'nullable|date',
            'incubation_status' => 'nullable|string',
            'hatched_count' => 'nullable|integer',
            'remarks' => 'nullable|string',
        ];
    }
}

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
            'collection_date'       => 'sometimes|date',
            'dam_id'                => 'sometimes|exists:game_fowls,id',
            'sire_id'               => 'sometimes|exists:game_fowls,id',
            'egg_count'             => 'sometimes|integer|min:1',
            'egg_condition'         => 'sometimes|string',
            'collection_staff'      => 'sometimes|string',
            'storage_location'      => 'sometimes|string',
            'incubation_start_date' => 'nullable|date',
            'expected_hatch_date'   => 'nullable|date',
            'incubated_count'       => 'nullable|integer|min:0',
            'hatched_count'         => 'nullable|integer|min:0',
            'failed_count'          => 'nullable|integer|min:0',
            'remarks'               => 'nullable|string',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $eggCollection = $this->route('egg_collection');
            $totalEggs     = $this->input('egg_count', $eggCollection?->egg_count ?? 0);
            $incubated     = (int) $this->input('incubated_count', 0);
            $hatched       = (int) $this->input('hatched_count', 0);
            $failed        = (int) $this->input('failed_count', 0);

            if ($incubated > $totalEggs) {
                $validator->errors()->add('incubated_count', "Incubated count ({$incubated}) cannot exceed total egg count ({$totalEggs}).");
            }

            if (($hatched + $failed) > $incubated) {
                $validator->errors()->add('hatched_count', "Hatched + Failed (" . ($hatched + $failed) . ") cannot exceed incubated count ({$incubated}).");
            }
        });
    }
}

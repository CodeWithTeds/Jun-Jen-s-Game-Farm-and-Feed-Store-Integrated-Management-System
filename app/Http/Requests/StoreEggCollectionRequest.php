<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEggCollectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        if ($this->has('breeding_id') && $this->breeding_id) {
            $breeding = \App\Models\Breeding::find($this->breeding_id);
            if ($breeding) {
                $this->merge([
                    'dam_id' => $breeding->dam_id,
                    'sire_id' => $breeding->sire_id,
                ]);
            }
        }
    }

    public function rules(): array
    {
        return [
            'breeding_id'      => 'required|exists:breedings,id',
            'collection_date'  => 'required|date',
            'dam_id'           => 'required|exists:game_fowls,id',
            'sire_id'          => 'required|exists:game_fowls,id',
            'egg_count'        => 'required|integer|min:1',
            'egg_condition'    => 'required|string',
            'collection_staff' => 'required|string',
            'storage_location' => 'required|string',
            'remarks'          => 'nullable|string',
        ];
    }
}

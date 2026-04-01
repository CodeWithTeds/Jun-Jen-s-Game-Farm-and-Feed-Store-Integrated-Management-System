<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEggCollectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
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

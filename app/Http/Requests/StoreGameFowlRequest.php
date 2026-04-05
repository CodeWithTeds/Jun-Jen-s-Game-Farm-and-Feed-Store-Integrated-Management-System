<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGameFowlRequest extends FormRequest
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
            'tag_id' => 'required|string|unique:game_fowls,tag_id',
            'name' => 'required|string|max:255',
            'sex' => 'required|string|in:Male,Female',
            'reproductive_status' => 'nullable|string|max:255',
            'gender_identification' => 'nullable|string|max:255',
            'date_hatched' => 'required|date',
            'stage_growth_phase' => 'required|string|in:Brooder,Starter,Grower,Stag,Pullet,Bullstag,Cock,Hen,Retired',
            'color_feather_pattern' => 'required|string|max:255',
            'distinctive_markings' => 'nullable|string|max:255',
            'acquisition_date' => 'required|date',
            'initial_health_status' => 'required|string|in:Healthy,Weak / Underweight,Sick,Injured,Dead',
            'sexual_maturity_status' => 'required|string|in:Immature,Developing,Mature,Retired',
            'special_notes' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'sire_id' => 'nullable|exists:game_fowls,id',
            'dam_id' => 'nullable|exists:game_fowls,id',
            'classification' => 'nullable|string|max:255',
            'conditioning_status' => 'nullable|string|max:255',
        ];
    }
}

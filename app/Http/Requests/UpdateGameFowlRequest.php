<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateGameFowlRequest extends FormRequest
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
        // Get the ID from the route parameter
        $gameFowlId = $this->route('game_fowl') ? $this->route('game_fowl')->id : null;

        return [
            'tag_id' => [
                'required',
                'string',
                Rule::unique('game_fowls', 'tag_id')->ignore($gameFowlId),
            ],
            'name' => 'required|string|max:255',
            'sex' => 'required|string|in:Male,Female',
            'date_hatched' => 'required|date',
            'stage_growth_phase' => 'required|string|max:255',
            'color_feather_pattern' => 'required|string|max:255',
            'distinctive_markings' => 'nullable|string|max:255',
            'acquisition_date' => 'required|date',
            'initial_health_status' => 'required|string|max:255',
            'sexual_maturity_status' => 'required|string|max:255',
            'special_notes' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
}

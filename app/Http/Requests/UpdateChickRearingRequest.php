<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateChickRearingRequest extends FormRequest
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
        $chickRearingId = $this->route('chick_rearing')->id ?? $this->route('chick_rearing');

        return [
            'chick_tag_id' => 'required|string|unique:chick_rearings,chick_tag_id,' . $chickRearingId,
            'hatch_date' => 'required|date',
            'age_days' => 'required|integer|min:0',
            'growth_stage' => 'required|string',
            'feed_type' => 'required|string',
            'feeding_schedule' => 'required|string',
            'health_status' => 'required|string',
            'vaccination_status' => 'required|string',
            'last_vaccination_date' => 'nullable|date',
            'treatment_notes' => 'nullable|string',
            'mortality_status' => 'required|string',
            'remarks' => 'nullable|string',
        ];
    }
}

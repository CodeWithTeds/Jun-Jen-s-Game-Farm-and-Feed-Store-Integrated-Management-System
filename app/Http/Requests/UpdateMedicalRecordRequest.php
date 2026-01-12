<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMedicalRecordRequest extends FormRequest
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
            'game_fowl_id' => 'required|exists:game_fowls,id',
            'date' => 'required|date',
            'type' => 'required|string',
            'medication_name' => 'nullable|string',
            'dosage' => 'nullable|string',
            'administered_by' => 'nullable|string',
            'notes' => 'nullable|string',
            'next_schedule_date' => 'nullable|date',
            'status' => 'required|string',
            'cost' => 'nullable|numeric',
            'technician_name' => 'nullable|string',
            'location' => 'nullable|string',
        ];
    }
}

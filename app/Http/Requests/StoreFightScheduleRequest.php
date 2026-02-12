<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreFightScheduleRequest extends FormRequest
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
            'game_fowl_id' => [
                'required',
                Rule::exists('game_fowls', 'id')->where(function ($query) {
                    $query->where('sex', 'Male');
                }),
            ],
            'date' => ['required', 'date'],
            'time' => ['required'],
            'location' => ['required', 'string', 'max:255'],
            'opponent' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'string', 'in:Scheduled,Completed,Cancelled'],
            'result' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
        ];
    }

    public function messages()
    {
        return [
            'game_fowl_id.exists' => 'The selected game fowl must be a Male.',
        ];
    }
}

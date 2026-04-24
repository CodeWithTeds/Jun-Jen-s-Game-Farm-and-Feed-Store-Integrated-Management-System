<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateFightScheduleRequest extends FormRequest
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
        $scheduleId = $this->route('fight_schedule');

        return [
            'game_fowl_id' => [
                'required',
                Rule::exists('game_fowls', 'id')->where(function ($query) {
                    $query->where('sex', 'Male');
                }),
                function ($attribute, $value, $fail) use ($scheduleId) {
                    $gameFowl = \App\Models\GameFowl::find($value);
                    if ($gameFowl) {
                        if ($gameFowl->initial_health_status === 'Dead') {
                            $fail('The selected game fowl is marked as dead and cannot be scheduled for a fight.');
                            return;
                        }

                        if ($gameFowl->classification !== 'Fighter') {
                            $fail("The selected game fowl is classified as '{$gameFowl->classification}' and cannot be scheduled for a fight. Only 'Fighter' classification is allowed.");
                            return;
                        }

                        if (!in_array($gameFowl->stage_growth_phase, ['Stag', 'Bullstag', 'Cock'])) {
                            $fail("The selected game fowl is in the '{$gameFowl->stage_growth_phase}' stage. Only fowls in 'Stag', 'Bullstag', or 'Cock' stages can be scheduled for fights.");
                            return;
                        }

                        $unfitRecord = $gameFowl->medicalRecords()
                            ->whereIn('type', ['Sick', 'Weak', 'Treatment'])
                            ->where('status', '!=', 'Completed')
                            ->latest()
                            ->first();

                        if ($unfitRecord) {
                            $fail("The selected game fowl is currently under {$unfitRecord->type} ({$unfitRecord->status}) and cannot be scheduled for a fight.");
                            return;
                        }

                        if ($gameFowl->fightSchedules()
                            ->where('status', 'Scheduled')
                            ->whereKeyNot($scheduleId)
                            ->exists()) {
                            $fail('The selected game fowl is already assigned to another scheduled fight.');
                        }
                    }
                },
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

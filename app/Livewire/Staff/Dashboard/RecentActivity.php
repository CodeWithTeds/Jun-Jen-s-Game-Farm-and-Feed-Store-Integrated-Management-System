<?php

namespace App\Livewire\Staff\Dashboard;

use Livewire\Component;
use App\Models\MedicalRecord;
use Illuminate\Support\Str;

class RecentActivity extends Component
{
    public function render()
    {
        $recentMedical = MedicalRecord::with('gameFowl')
            ->latest('date')
            ->take(5)
            ->get();

        return view('livewire.staff.dashboard.recent-activity', [
            'recentMedical' => $recentMedical,
        ]);
    }
}

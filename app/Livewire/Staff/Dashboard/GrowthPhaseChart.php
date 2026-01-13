<?php

namespace App\Livewire\Staff\Dashboard;

use Livewire\Component;
use App\Models\GameFowl;
use Illuminate\Support\Facades\DB;

class GrowthPhaseChart extends Component
{
    public function render()
    {
        $fowlStatus = GameFowl::select('stage_growth_phase', DB::raw('count(*) as total'))
            ->groupBy('stage_growth_phase')
            ->pluck('total', 'stage_growth_phase')
            ->toArray();

        return view('livewire.staff.dashboard.growth-phase-chart', [
            'fowlStatus' => $fowlStatus,
        ]);
    }
}

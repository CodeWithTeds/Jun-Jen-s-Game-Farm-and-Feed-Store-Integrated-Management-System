<?php

namespace App\Livewire\Staff\Dashboard;

use Livewire\Component;
use App\Models\EggCollection;
use Carbon\Carbon;

class EggProductionChart extends Component
{
    public function render()
    {
        $eggData = EggCollection::selectRaw('DATE(collection_date) as date, SUM(egg_count) as total')
            ->where('collection_date', '>=', Carbon::now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $labels = [];
        $values = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $labels[] = Carbon::parse($date)->format('M d');
            $record = $eggData->firstWhere('date', $date);
            $values[] = $record ? $record->total : 0;
        }

        return view('livewire.staff.dashboard.egg-production-chart', [
            'labels' => $labels,
            'values' => $values,
        ]);
    }
}

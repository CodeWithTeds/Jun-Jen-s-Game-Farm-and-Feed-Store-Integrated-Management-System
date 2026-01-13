<?php

namespace App\Livewire\Staff\Dashboard;

use Livewire\Component;
use App\Models\GameFowl;
use App\Models\Feed;
use App\Models\EggCollection;
use App\Models\ChickRearing;
use Carbon\Carbon;

class StatsCards extends Component
{
    public function render()
    {
        $totalGameFowls = GameFowl::count();
        $todayEggs = EggCollection::whereDate('collection_date', Carbon::today())->sum('egg_count');
        $activeBatches = ChickRearing::count();
        $lowStockFeeds = Feed::whereColumn('quantity', '<=', 'reorder_level')->count();

        return view('livewire.staff.dashboard.stats-cards', [
            'totalGameFowls' => $totalGameFowls,
            'todayEggs' => $todayEggs,
            'activeBatches' => $activeBatches,
            'lowStockFeeds' => $lowStockFeeds,
        ]);
    }
}

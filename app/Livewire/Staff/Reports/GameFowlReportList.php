<?php

namespace App\Livewire\Staff\Reports;

use App\Models\GameFowl;
use Livewire\Component;
use Livewire\WithPagination;

class GameFowlReportList extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        $gameFowls = GameFowl::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('tag_id', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('livewire.staff.reports.game-fowl-report-list', [
            'gameFowls' => $gameFowls
        ]);
    }
}

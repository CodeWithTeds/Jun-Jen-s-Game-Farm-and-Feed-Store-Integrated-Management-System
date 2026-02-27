<?php

namespace App\Livewire\Staff\Reports;

use App\Models\GameFowl;
use Livewire\Component;

class GameFowlReportShow extends Component
{
    public GameFowl $gameFowl;

    public function mount(GameFowl $gameFowl)
    {
        $this->gameFowl = $gameFowl->load(['medicalRecords', 'fightSchedules']);
    }

    public function render()
    {
        return view('livewire.staff.reports.game-fowl-report-show');
    }
}

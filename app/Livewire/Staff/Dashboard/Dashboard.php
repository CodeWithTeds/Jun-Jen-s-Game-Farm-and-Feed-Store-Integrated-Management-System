<?php

namespace App\Livewire\Staff\Dashboard;

use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Staff Dashboard')]
class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.staff.dashboard');
    }
}

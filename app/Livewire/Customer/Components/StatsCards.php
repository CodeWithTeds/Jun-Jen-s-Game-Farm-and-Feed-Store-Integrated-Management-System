<?php

namespace App\Livewire\Customer\Components;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class StatsCards extends Component
{
    public function render()
    {
        $user = Auth::user();

        $stats = [
            'total_orders' => Order::where('user_id', $user->id)->count(),
            'total_spent' => Order::where('user_id', $user->id)->where('status', 'completed')->sum('total_amount'),
            'active_orders' => Order::where('user_id', $user->id)->whereIn('status', ['pending', 'processing', 'shipped'])->count(),
        ];

        return view('livewire.customer.components.stats-cards', ['stats' => $stats]);
    }
}

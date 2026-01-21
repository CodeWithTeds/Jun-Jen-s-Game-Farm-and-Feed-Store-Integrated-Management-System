<?php

namespace App\Livewire\Customer\Components;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class RecentOrders extends Component
{
    public function render()
    {
        $user = Auth::user();
        
        $recentOrders = Order::where('user_id', $user->id)
            ->with(['items.feed'])
            ->latest()
            ->take(5)
            ->get();

        return view('livewire.customer.components.recent-orders', ['recentOrders' => $recentOrders]);
    }
}

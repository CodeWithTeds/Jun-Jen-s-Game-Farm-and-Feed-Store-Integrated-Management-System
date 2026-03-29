<?php

namespace App\Livewire\Customer\Components;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SpendingChart extends Component
{
    public function render()
    {
        $user = Auth::user();
        
        $query = Order::where('user_id', $user->id)
            ->where('status', 'completed');

        $chartData = $query->selectRaw('DATE(created_at) as date, SUM(total_amount) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->map(function ($item) {
                return [
                    'date' => Carbon::parse($item->date)->format('M d'),
                    'total' => $item->total,
                ];
            });

        return view('livewire.customer.components.spending-chart', ['chartData' => $chartData]);
    }
}

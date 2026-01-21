<?php

namespace App\Livewire\Customer\Components;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SpendingChart extends Component
{
    public $dateRange = '30_days';

    public function render()
    {
        $user = Auth::user();
        
        $query = Order::where('user_id', $user->id)
            ->where('status', 'completed');
            
        // Apply date filters
        if ($this->dateRange === '7_days') {
            $query->where('created_at', '>=', now()->subDays(7));
        } elseif ($this->dateRange === '30_days') {
            $query->where('created_at', '>=', now()->subDays(30));
        } elseif ($this->dateRange === 'this_month') {
            $query->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year);
        }

        $chartData = $query->selectRaw('DATE(created_at) as date, SUM(total_amount) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->map(function ($item) {
                return [
                    'date' => $item->date,
                    'total' => $item->total,
                ];
            });

        return view('livewire.customer.components.spending-chart', ['chartData' => $chartData]);
    }
}

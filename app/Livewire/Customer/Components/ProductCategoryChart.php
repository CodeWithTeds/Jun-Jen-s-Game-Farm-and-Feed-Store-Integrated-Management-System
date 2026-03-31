<?php

namespace App\Livewire\Customer\Components;

use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ProductCategoryChart extends Component
{
    public function render()
    {
        $userId = Auth::id();

        // Get count of items bought per category (Feeds vs Game Fowl)
        $data = OrderItem::join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.user_id', $userId)
            ->select([
                DB::raw("CASE 
                    WHEN feed_id IS NOT NULL THEN 'Feeds' 
                    WHEN game_fowl_id IS NOT NULL THEN 'Game Fowl' 
                    ELSE 'Other' 
                END as category"),
                DB::raw('SUM(quantity) as val')
            ])
            ->groupBy('category')
            ->get();

        return view('livewire.customer.components.product-category-chart', [
            'chartData' => $data
        ]);
    }
}

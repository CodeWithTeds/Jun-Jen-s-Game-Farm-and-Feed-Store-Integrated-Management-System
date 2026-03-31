<?php

namespace App\Livewire\Customer;

use Livewire\Component;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class ReceiptLogs extends Component
{
    public $selectedOrder = null;

    public function showReceipt($orderId)
    {
        $this->selectedOrder = Order::with('items.feed', 'items.gameFowl')->find($orderId);
    }

    public function closeReceipt()
    {
        $this->selectedOrder = null;
    }

    public function render()
    {
        $orders = Order::where('user_id', Auth::id())
            ->latest()
            ->paginate(15);

        return view('livewire.customer.receipt-logs', [
            'orders' => $orders
        ]);
    }
}

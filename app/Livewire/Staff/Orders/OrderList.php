<?php

namespace App\Livewire\Staff\Orders;

use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;

class OrderList extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $selectedOrder = null;
    public $showOrderModal = false;

    // For status update
    public $newStatus;

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedStatusFilter()
    {
        $this->resetPage();
    }

    public function viewOrder($orderId)
    {
        $this->selectedOrder = Order::with(['user', 'items.feed'])->find($orderId);

        if ($this->selectedOrder) {
            $this->newStatus = $this->selectedOrder->status;
            $this->showOrderModal = true;
        } else {
            $this->dispatch('notify', message: 'Order not found.', type: 'error');
        }
    }

    public function closeOrderModal()
    {
        $this->showOrderModal = false;
        $this->selectedOrder = null;
    }

    public function updateStatus()
    {
        if ($this->selectedOrder) {
            $this->selectedOrder->update([
                'status' => $this->newStatus
            ]);

            $this->showOrderModal = false;
            $this->dispatch('notify', message: 'Order status updated successfully.');
        }
    }

    public function render()
    {
        $orders = Order::with('user')
            ->when($this->search, function ($query) {
                $query->where('order_number', 'like', '%' . $this->search . '%')
                    ->orWhereHas('user', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%');
                    });
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->latest()
            ->paginate(10);

        return view('livewire.staff.orders.order-list', [
            'orders' => $orders
        ]);
    }
}

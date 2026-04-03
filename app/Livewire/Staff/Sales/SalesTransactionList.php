<?php

namespace App\Livewire\Staff\Sales;

use App\Services\SalesTransactionService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class SalesTransactionList extends Component
{
    use WithPagination;

    protected $salesService;

    public $search = '';
    public $statusFilter = '';
    public $paymentStatusFilter = '';
    public $paymentMethodFilter = '';
    public $transactionTypeFilter = '';
    public $periodFilter = '';
    public $dateFrom = '';
    public $dateTo = '';
    public $perPage = 10;

    public $selectedTransaction = null;
    public $showTransactionModal = false;
    public $newStatus;
    public $newPaymentStatus;

    public function boot(SalesTransactionService $salesService)
    {
        $this->salesService = $salesService;
    }

    public function mount()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user->isAdmin()) {
            abort(403);
        }
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedStatusFilter()
    {
        $this->resetPage();
    }

    public function updatedPaymentStatusFilter()
    {
        $this->resetPage();
    }

    public function updatedPeriodFilter()
    {
        if ($this->periodFilter === 'today') {
            $this->dateFrom = now()->startOfDay()->toDateString();
            $this->dateTo = now()->endOfDay()->toDateString();
        } elseif ($this->periodFilter === 'this_month') {
            $this->dateFrom = now()->startOfMonth()->toDateString();
            $this->dateTo = now()->endOfMonth()->toDateString();
        } elseif ($this->periodFilter === 'this_year') {
            $this->dateFrom = now()->startOfYear()->toDateString();
            $this->dateTo = now()->endOfYear()->toDateString();
        } else {
            $this->dateFrom = '';
            $this->dateTo = '';
        }
        $this->resetPage();
    }

    public function updatedDateFrom()
    {
        $this->resetPage();
    }

    public function updatedDateTo()
    {
        $this->resetPage();
    }

    public function viewTransaction($id)
    {
        $this->selectedTransaction = $this->salesService->getTransactionById($id);

        if ($this->selectedTransaction) {
            $this->newStatus = $this->selectedTransaction->status;
            $this->newPaymentStatus = $this->selectedTransaction->payment_status;
            $this->showTransactionModal = true;
        } else {
            $this->dispatch('notify', message: 'Transaction not found.', type: 'error');
        }
    }

    public function closeTransactionModal()
    {
        $this->showTransactionModal = false;
        $this->selectedTransaction = null;
    }

    public function updateTransaction()
    {
        if ($this->selectedTransaction) {
            if ($this->newStatus !== $this->selectedTransaction->status) {
                $this->salesService->updateTransactionStatus($this->selectedTransaction->id, $this->newStatus);
            }

            if ($this->newPaymentStatus !== $this->selectedTransaction->payment_status) {
                $this->salesService->updatePaymentStatus($this->selectedTransaction->id, $this->newPaymentStatus);
            }

            $this->showTransactionModal = false;
            $this->dispatch('notify', message: 'Transaction updated successfully.');
        }
    }

    public function deleteTransaction($id)
    {
        if ($this->salesService->deleteTransaction($id)) {
            $this->dispatch('notify', message: 'Transaction deleted successfully.');
        } else {
            $this->dispatch('notify', message: 'Failed to delete transaction.', type: 'error');
        }
    }
    public function exportReport()
    {
        $filters = [
            'search' => $this->search,
            'status' => $this->statusFilter,
            'payment_status' => $this->paymentStatusFilter,
            'payment_method' => $this->paymentMethodFilter,
            'date_from' => $this->dateFrom,
            'date_to' => $this->dateTo,
            'transaction_type' => $this->transactionTypeFilter,
        ];

        $transactions = $this->salesService->getForExport($filters);

        return response()->streamDownload(function () use ($transactions) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Transaction ID', 'Customer', 'Email', 'Date', 'Total Amount', 'Status', 'Payment Method', 'Payment Status', 'Items']);

            foreach ($transactions as $transaction) {
                $items = $transaction->items->map(function($item) {
                    $name = $item->feed ? $item->feed->feed_name : ($item->gameFowl ? $item->gameFowl->name : 'Unknown');
                    return $name . ' (Qty: ' . $item->quantity . ')';
                })->implode('; ');

                fputcsv($file, [
                    $transaction->order_number,
                    $transaction->user->name ?? 'Guest',
                    $transaction->user->email ?? 'N/A',
                    $transaction->created_at->format('Y-m-d H:i:s'),
                    $transaction->total_amount,
                    $transaction->status,
                    $transaction->payment_method,
                    $transaction->payment_status,
                    $items
                ]);
            }
            fclose($file);
        }, 'sales_report_' . date('Y-m-d_H-i-s') . '.csv');
    }

    public function render()
    {
        $filters = [
            'search' => $this->search,
            'status' => $this->statusFilter,
            'payment_status' => $this->paymentStatusFilter,
            'payment_method' => $this->paymentMethodFilter,
            'date_from' => $this->dateFrom,
            'date_to' => $this->dateTo,
            'transaction_type' => $this->transactionTypeFilter,
        ];

        $transactions = $this->salesService->getAllTransactions($filters, $this->perPage);
        $stats = $this->salesService->getTransactionStats($filters);

        return view('livewire.staff.sales.sales-transaction-list', [
            'transactions' => $transactions,
            'stats' => $stats
        ]);
    }
}

<?php

namespace App\Livewire\Staff\Sales;

use App\Services\SalesTransactionService;
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

    public function render()
    {
        $filters = [
            'search' => $this->search,
            'status' => $this->statusFilter,
            'payment_status' => $this->paymentStatusFilter,
            'payment_method' => $this->paymentMethodFilter,
            'date_from' => $this->dateFrom,
            'date_to' => $this->dateTo,
        ];

        $transactions = $this->salesService->getAllTransactions($filters, $this->perPage);
        $stats = $this->salesService->getTransactionStats($filters);

        return view('livewire.staff.sales.sales-transaction-list', [
            'transactions' => $transactions,
            'stats' => $stats
        ]);
    }
}

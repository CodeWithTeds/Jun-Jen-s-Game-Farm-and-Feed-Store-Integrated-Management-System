<?php

namespace App\Services;

use App\Repositories\Contracts\SalesTransactionRepositoryInterface;

class SalesTransactionService
{
    protected $repository;

    public function __construct(SalesTransactionRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getAllTransactions(array $filters = [], int $perPage = 10)
    {
        return $this->repository->getAll($filters, $perPage);
    }

    public function getTransactionById($id)
    {
        return $this->repository->getById($id);
    }

    public function updateTransactionStatus($id, $status)
    {
        return $this->repository->update($id, ['status' => $status]);
    }

    public function updatePaymentStatus($id, $status)
    {
        return $this->repository->update($id, ['payment_status' => $status]);
    }

    public function deleteTransaction($id)
    {
        return $this->repository->delete($id);
    }

    public function getTransactionStats(array $filters = [])
    {
        return $this->repository->getStats($filters);
    }
}

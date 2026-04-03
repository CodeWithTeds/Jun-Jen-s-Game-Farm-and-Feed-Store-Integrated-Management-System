<?php

namespace App\Repositories\Contracts;

interface SalesTransactionRepositoryInterface
{
    public function getAll(array $filters = [], int $perPage = 10);
    public function getForExport(array $filters = []);
    public function getById($id);
    public function update($id, array $data);
    public function delete($id);
    public function getStats(array $filters = []);
}

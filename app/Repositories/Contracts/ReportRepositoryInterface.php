<?php

namespace App\Repositories\Contracts;

interface ReportRepositoryInterface
{
    public function getSalesReport(array $filters);
    public function getTopSellingProducts(array $filters, int $limit = 5);
    public function getInventorySummary();
}

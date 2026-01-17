<?php

namespace App\Services;

use App\Repositories\Contracts\ReportRepositoryInterface;

class ReportService
{
    protected $reportRepository;

    public function __construct(ReportRepositoryInterface $reportRepository)
    {
        $this->reportRepository = $reportRepository;
    }

    public function getDashboardData(array $filters)
    {
        return [
            'sales_report' => $this->reportRepository->getSalesReport($filters),
            'top_products' => $this->reportRepository->getTopSellingProducts($filters),
            'inventory_summary' => $this->reportRepository->getInventorySummary(),
        ];
    }
}

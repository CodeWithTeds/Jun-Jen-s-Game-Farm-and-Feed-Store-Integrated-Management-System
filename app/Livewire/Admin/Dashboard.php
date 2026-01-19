<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Contracts\ReportRepositoryInterface;
use App\Repositories\Contracts\SalesTransactionRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Contracts\FeedRepositoryInterface;

class Dashboard extends Component
{
    public $dateRange = '30_days'; // default
    public $customDateFrom;
    public $customDateTo;

    public function mount()
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        
        if (!$user?->isAdmin()) {
            abort(403);
        }
        // Initialize dates if needed
    }

    #[Layout('components.layouts.app')]
    public function render(
        ReportRepositoryInterface $reportRepo,
        SalesTransactionRepositoryInterface $salesRepo,
        UserRepositoryInterface $userRepo,
        FeedRepositoryInterface $feedRepo
    ) {
        // Determine date filters
        $filters = $this->getDateFilters();

        // 1. Summary Cards Data
        $salesStats = $salesRepo->getStats($filters);
        $inventoryStats = $reportRepo->getInventorySummary();
        $totalUsers = $userRepo->all()->count(); // Assuming all() returns Collection

        // 2. Charts Data
        $salesReport = $reportRepo->getSalesReport($filters);
        $salesChartData = $salesReport['sales_chart'];
        
        $topProducts = $reportRepo->getTopSellingProducts($filters, 5);
        $topProductsLabels = $topProducts->pluck('feed.feed_name')->toArray();
        $topProductsData = $topProducts->pluck('total_quantity')->toArray();

        // 3. Tables Data
        $recentOrders = $salesRepo->getAll(['sort_by' => 'created_at', 'sort_order' => 'desc'], 5);
        $lowStockItems = $feedRepo->getLowStock(5);

        return view('livewire.admin.dashboard', [
            'stats' => [
                'total_sales' => $salesStats['total_sales'],
                'total_orders' => $salesStats['total_orders'],
                'pending_orders' => $salesStats['pending_orders'],
                'total_users' => $totalUsers,
                'low_stock_count' => $inventoryStats['low_stock'],
                'total_products' => $inventoryStats['total_products'],
            ],
            'salesChartData' => $salesChartData,
            'topProducts' => [
                'labels' => $topProductsLabels,
                'data' => $topProductsData,
            ],
            'recentOrders' => $recentOrders,
            'lowStockItems' => $lowStockItems,
        ]);
    }

    protected function getDateFilters()
    {
        $filters = [];
        $now = now();

        switch ($this->dateRange) {
            case '7_days':
                $filters['date_from'] = $now->copy()->subDays(7)->format('Y-m-d');
                break;
            case '30_days':
                $filters['date_from'] = $now->copy()->subDays(30)->format('Y-m-d');
                break;
            case 'this_month':
                $filters['date_from'] = $now->copy()->startOfMonth()->format('Y-m-d');
                $filters['date_to'] = $now->copy()->endOfMonth()->format('Y-m-d');
                break;
            case 'last_month':
                $filters['date_from'] = $now->copy()->subMonth()->startOfMonth()->format('Y-m-d');
                $filters['date_to'] = $now->copy()->subMonth()->endOfMonth()->format('Y-m-d');
                break;
            case 'custom':
                if ($this->customDateFrom) $filters['date_from'] = $this->customDateFrom;
                if ($this->customDateTo) $filters['date_to'] = $this->customDateTo;
                break;
        }

        return $filters;
    }
}

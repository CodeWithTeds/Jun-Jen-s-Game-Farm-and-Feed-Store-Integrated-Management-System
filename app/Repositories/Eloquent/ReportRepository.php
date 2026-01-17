<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\ReportRepositoryInterface;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Feed;
use Illuminate\Support\Facades\DB;

class ReportRepository implements ReportRepositoryInterface
{
    public function getSalesReport(array $filters)
    {
        $query = Order::query()->where('status', 'completed');

        if (isset($filters['date_from'])) {
            $query->whereDate('created_at', '>=', $filters['date_from']);
        }

        if (isset($filters['date_to'])) {
            $query->whereDate('created_at', '<=', $filters['date_to']);
        }

        return [
            'total_sales' => $query->sum('total_amount'),
            'total_orders' => $query->count(),
            'average_order_value' => $query->avg('total_amount') ?? 0,
            'sales_chart' => $query->selectRaw('DATE(created_at) as date, SUM(total_amount) as total')
                ->groupBy('date')
                ->orderBy('date')
                ->get()
        ];
    }

    public function getTopSellingProducts(array $filters, int $limit = 5)
    {
        $query = OrderItem::query()
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'completed')
            ->select('feed_id', DB::raw('SUM(order_items.quantity) as total_quantity'), DB::raw('SUM(order_items.price * order_items.quantity) as total_revenue'))
            ->groupBy('feed_id')
            ->orderByDesc('total_quantity')
            ->with('feed');

        if (isset($filters['date_from'])) {
            $query->whereDate('orders.created_at', '>=', $filters['date_from']);
        }

        if (isset($filters['date_to'])) {
            $query->whereDate('orders.created_at', '<=', $filters['date_to']);
        }

        return $query->take($limit)->get();
    }

    public function getInventorySummary()
    {
        return [
            'total_products' => Feed::count(),
            'low_stock' => Feed::whereColumn('quantity', '<=', 'reorder_level')->count(),
            'out_of_stock' => Feed::where('quantity', '<=', 0)->count(),
            'total_inventory_value' => Feed::sum(DB::raw('quantity * price')),
        ];
    }
}

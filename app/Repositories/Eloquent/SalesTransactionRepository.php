<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\SalesTransactionRepositoryInterface;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Pagination\LengthAwarePaginator;

class SalesTransactionRepository implements SalesTransactionRepositoryInterface
{
    public function getAll(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        $query = Order::query()->with(['user', 'items.feed', 'items.gameFowl']);

        if (isset($filters['search']) && $filters['search']) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        if (isset($filters['status']) && $filters['status']) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['payment_status']) && $filters['payment_status']) {
            $query->where('payment_status', $filters['payment_status']);
        }

        if (isset($filters['payment_method']) && $filters['payment_method']) {
            $query->where('payment_method', $filters['payment_method']);
        }

        if (isset($filters['date_from']) && $filters['date_from']) {
            $query->whereDate('created_at', '>=', $filters['date_from']);
        }

        if (isset($filters['date_to']) && $filters['date_to']) {
            $query->whereDate('created_at', '<=', $filters['date_to']);
        }

        if (isset($filters['sort_by']) && isset($filters['sort_order'])) {
            $query->orderBy($filters['sort_by'], $filters['sort_order']);
        } else {
            $query->latest();
        }

        return $query->paginate($perPage);
    }

    public function getById($id)
    {
        return Order::with(['user', 'items.feed', 'items.gameFowl'])->find($id);
    }

    public function update($id, array $data)
    {
        $order = Order::find($id);
        if ($order) {
            $order->update($data);
            return $order;
        }
        return null;
    }

    public function delete($id)
    {
        $order = Order::find($id);
        if ($order) {
            return $order->delete();
        }
        return false;
    }

    public function getStats(array $filters = [])
    {
        $query = Order::query();

        if (isset($filters['date_from']) && $filters['date_from']) {
            $query->whereDate('created_at', '>=', $filters['date_from']);
        }

        if (isset($filters['date_to']) && $filters['date_to']) {
            $query->whereDate('created_at', '<=', $filters['date_to']);
        }

        // Calculate split sales
        $storeSales = OrderItem::whereHas('order', function($q) use ($filters) {
             if (isset($filters['date_from']) && $filters['date_from']) {
                $q->whereDate('created_at', '>=', $filters['date_from']);
            }
            if (isset($filters['date_to']) && $filters['date_to']) {
                $q->whereDate('created_at', '<=', $filters['date_to']);
            }
        })->whereNotNull('feed_id')->selectRaw('sum(quantity * price) as total')->value('total') ?? 0;

        $chickenSales = OrderItem::whereHas('order', function($q) use ($filters) {
             if (isset($filters['date_from']) && $filters['date_from']) {
                $q->whereDate('created_at', '>=', $filters['date_from']);
            }
            if (isset($filters['date_to']) && $filters['date_to']) {
                $q->whereDate('created_at', '<=', $filters['date_to']);
            }
        })->whereNotNull('game_fowl_id')->selectRaw('sum(quantity * price) as total')->value('total') ?? 0;

        return [
            'total_sales' => $query->sum('total_amount'),
            'store_sales' => $storeSales,
            'chicken_sales' => $chickenSales,
            'total_orders' => $query->count(),
            'pending_orders' => (clone $query)->where('status', 'pending')->count(),
            'completed_orders' => (clone $query)->where('status', 'completed')->count(),
        ];
    }
}

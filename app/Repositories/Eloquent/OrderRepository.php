<?php

namespace App\Repositories\Eloquent;

use App\Models\Order;
use App\Models\OrderItem;
use App\Repositories\Contracts\OrderRepositoryInterface;

class OrderRepository implements OrderRepositoryInterface
{
    public function create(array $data)
    {
        return Order::create($data);
    }

    public function createItem(array $data)
    {
        return OrderItem::create($data);
    }

    public function getById(int $id)
    {
        return Order::with(['items.feed'])->find($id);
    }

    public function getByUserId(int $userId)
    {
        return Order::with(['items.feed'])->where('user_id', $userId)->orderBy('created_at', 'desc')->get();
    }
}

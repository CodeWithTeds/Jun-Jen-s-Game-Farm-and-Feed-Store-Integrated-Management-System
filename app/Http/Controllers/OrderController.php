<?php

namespace App\Http\Controllers;

use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index()
    {
        $userId = Auth::id();
        $orders = $this->orderService->getUserOrders($userId);
        return view('orders.customer_index', compact('orders'));
    }

    public function show($id)
    {
        $userId = Auth::id();
        $order = $this->orderService->getOrderById($id);

        if (!$order || $order->user_id !== $userId) {
            abort(403, 'Unauthorized access to this order.');
        }

        return view('orders.customer_show', compact('order'));
    }
}

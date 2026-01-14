<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;

class CartController extends Controller
{
    protected $cartService;
    protected $orderService;

    public function __construct(CartService $cartService, OrderService $orderService)
    {
        $this->cartService = $cartService;
        $this->orderService = $orderService;
    }

    public function index()
    {
        $userId = Auth::id();
        $cart = $this->cartService->getCart($userId);
        return response()->json([
            'cart' => $cart,
            'items' => $cart->items->map(function($item) {
                return [
                    'id' => $item->id,
                    'feed_id' => $item->feed_id,
                    'name' => $item->feed->feed_name,
                    'image' => $item->feed->image, // Assuming image path/url
                    'price' => $item->feed->price,
                    'quantity' => $item->quantity,
                    'total' => $item->quantity * $item->feed->price,
                ];
            }),
            'subtotal' => $cart->items->sum(fn($item) => $item->quantity * $item->feed->price)
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'feed_id' => 'required|exists:feeds,id',
            'quantity' => 'required|integer|min:1'
        ]);

        try {
            $userId = Auth::id();
            $this->cartService->addToCart($userId, $request->feed_id, $request->quantity);
            return response()->json(['message' => 'Item added to cart']);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function update(Request $request, $itemId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:0'
        ]);

        try {
            $userId = Auth::id();
            $this->cartService->updateItemQuantity($userId, $itemId, $request->quantity);
            return response()->json(['message' => 'Cart updated']);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function destroy($itemId)
    {
        try {
            $userId = Auth::id();
            $this->cartService->removeItem($userId, $itemId);
            return response()->json(['message' => 'Item removed']);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|string',
            'note' => 'nullable|string'
        ]);

        try {
            $userId = Auth::id();
            $order = $this->orderService->checkout($userId, $request->payment_method, $request->note);
            return response()->json(['message' => 'Order placed successfully', 'order_id' => $order->id]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }
}

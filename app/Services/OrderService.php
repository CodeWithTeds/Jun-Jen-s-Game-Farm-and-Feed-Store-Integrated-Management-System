<?php

namespace App\Services;

use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Repositories\Contracts\CartRepositoryInterface;
use App\Repositories\Contracts\FeedRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Exception;

class OrderService
{
    protected $orderRepository;
    protected $cartRepository;
    protected $feedRepository;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        CartRepositoryInterface $cartRepository,
        FeedRepositoryInterface $feedRepository
    ) {
        $this->orderRepository = $orderRepository;
        $this->cartRepository = $cartRepository;
        $this->feedRepository = $feedRepository;
    }

    public function getUserOrders(int $userId)
    {
        return $this->orderRepository->getByUserId($userId);
    }

    public function getOrderById(int $id)
    {
        return $this->orderRepository->getById($id);
    }

    public function checkout(int $userId, string $paymentMethod, string $shippingAddress, ?string $note, ?string $proofOfPayment = null, ?float $amountTendered = null, ?float $changeAmount = null)
    {
        return DB::transaction(function () use ($userId, $paymentMethod, $shippingAddress, $note, $proofOfPayment, $amountTendered, $changeAmount) {
            // Step 1: Validate Cart and Inventory
            $cart = $this->cartRepository->getActiveCart($userId);
            if (!$cart || $cart->items->isEmpty()) {
                throw new Exception("Cart is empty.");
            }

            // Update user address if not set
            $user = \App\Models\User::find($userId);
            if ($user && empty($user->address)) {
                $user->update(['address' => $shippingAddress]);
            }

            $totalAmount = 0;
            foreach ($cart->items as $item) {
                if ($item->feed_id) {
                    $feed = $this->feedRepository->getById($item->feed_id);
                    if (!$feed) {
                        throw new Exception("Feed {$item->feed_id} not found.");
                    }
                    if ($feed->quantity < $item->quantity) {
                        throw new Exception("Insufficient stock for {$feed->feed_name}.");
                    }
                    $totalAmount += $item->quantity * $feed->price;
                } elseif ($item->game_fowl_id) {
                    $gameFowl = \App\Models\GameFowl::find($item->game_fowl_id);
                    if (!$gameFowl) {
                        throw new Exception("Game Fowl {$item->game_fowl_id} not found.");
                    }
                    if ($gameFowl->sale_status !== 'for_sale') {
                        throw new Exception("Game Fowl {$gameFowl->name} is no longer for sale.");
                    }
                    $totalAmount += $gameFowl->price;
                }
            }

            // Step 2: Create Order
            $paymentStatus = ($paymentMethod === 'cash') ? 'pending' : 'paid';

            $orderData = [
                'user_id' => $userId,
                'order_number' => 'ORD-' . strtoupper(uniqid()),
                'total_amount' => $totalAmount,
                'amount_tendered' => $amountTendered,
                'change_amount' => $changeAmount,
                'status' => 'pending',
                'payment_status' => $paymentStatus,
                'shipping_address' => $shippingAddress,
                'payment_method' => $paymentMethod,
                'note' => $note,
                'proof_of_payment' => $proofOfPayment
            ];
            $order = $this->orderRepository->create($orderData);

            // Step 3: Create Order Items and Deduct Stock
            foreach ($cart->items as $item) {
                if ($item->feed_id) {
                    $feed = $this->feedRepository->getById($item->feed_id);
                    
                    $this->orderRepository->createItem([
                        'order_id' => $order->id,
                        'feed_id' => $item->feed_id,
                        'quantity' => $item->quantity,
                        'price' => $feed->price
                    ]);

                    // Deduct stock
                    $this->feedRepository->update($feed->id, [
                        'quantity' => $feed->quantity - $item->quantity
                    ]);
                } elseif ($item->game_fowl_id) {
                    $gameFowl = \App\Models\GameFowl::find($item->game_fowl_id);

                    $this->orderRepository->createItem([
                        'order_id' => $order->id,
                        'game_fowl_id' => $item->game_fowl_id,
                        'quantity' => 1,
                        'price' => $gameFowl->price
                    ]);

                    // Mark game fowl as sold
                    $gameFowl->update(['sale_status' => 'sold']);
                }
            }

            // Step 4: Clear Cart
            $this->cartRepository->clearCart($cart->id);

            // Step 5: Finalize Order
            // Order status remains pending until staff processes it.
            // Payment status is set based on method above.

            return $order;
        });
    }

    public function cancelOrder(int $orderId)
    {
        return DB::transaction(function () use ($orderId) {
            $order = $this->orderRepository->getById($orderId);
            if (!$order) {
                throw new Exception("Order not found.");
            }

            if ($order->status === 'cancelled') {
                throw new Exception("Order is already cancelled.");
            }

            if ($order->status === 'completed') {
                throw new Exception("Cannot cancel a completed order.");
            }

            // Restore stock and game fowl status
            foreach ($order->items as $item) {
                if ($item->feed_id) {
                    $feed = $this->feedRepository->getById($item->feed_id);
                    if ($feed) {
                        $this->feedRepository->update($feed->id, [
                            'quantity' => $feed->quantity + $item->quantity
                        ]);
                    }
                } elseif ($item->game_fowl_id) {
                    $gameFowl = \App\Models\GameFowl::find($item->game_fowl_id);
                    if ($gameFowl) {
                        $gameFowl->update(['sale_status' => 'for_sale']);
                    }
                }
            }

            $order->update(['status' => 'cancelled']);
            return $order;
        });
    }
}

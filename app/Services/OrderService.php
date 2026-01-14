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

    public function checkout(int $userId, string $paymentMethod, ?string $note, ?string $proofOfPayment = null)
    {
        return DB::transaction(function () use ($userId, $paymentMethod, $note, $proofOfPayment) {
            // Step 1: Validate Cart and Inventory
            $cart = $this->cartRepository->getActiveCart($userId);
            if (!$cart || $cart->items->isEmpty()) {
                throw new Exception("Cart is empty.");
            }

            $totalAmount = 0;
            foreach ($cart->items as $item) {
                $feed = $this->feedRepository->getById($item->feed_id);
                if (!$feed) {
                    throw new Exception("Feed {$item->feed_id} not found.");
                }
                if ($feed->quantity < $item->quantity) {
                    throw new Exception("Insufficient stock for {$feed->feed_name}.");
                }
                $totalAmount += $item->quantity * $feed->price;
            }

            // Step 2: Create Order
            $paymentStatus = ($paymentMethod === 'cash') ? 'pending' : 'paid';

            $orderData = [
                'user_id' => $userId,
                'order_number' => 'ORD-' . strtoupper(uniqid()),
                'total_amount' => $totalAmount,
                'status' => 'pending',
                'payment_status' => $paymentStatus,
                'payment_method' => $paymentMethod,
                'note' => $note,
                'proof_of_payment' => $proofOfPayment
            ];
            $order = $this->orderRepository->create($orderData);

            // Step 3: Create Order Items and Deduct Stock
            foreach ($cart->items as $item) {
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
            }

            // Step 4: Clear Cart
            $this->cartRepository->clearCart($cart->id);

            // Step 5: Finalize Order
            // Order status remains pending until staff processes it.
            // Payment status is set based on method above.

            return $order;
        });
    }
}

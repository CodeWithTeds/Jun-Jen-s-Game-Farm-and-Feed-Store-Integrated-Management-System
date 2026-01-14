<?php

namespace App\Services;

use App\Repositories\Contracts\CartRepositoryInterface;
use App\Repositories\Contracts\FeedRepositoryInterface;
use Exception;

class CartService
{
    protected $cartRepository;
    protected $feedRepository;

    public function __construct(
        CartRepositoryInterface $cartRepository,
        FeedRepositoryInterface $feedRepository
    ) {
        $this->cartRepository = $cartRepository;
        $this->feedRepository = $feedRepository;
    }

    public function getCart(int $userId)
    {
        $cart = $this->cartRepository->getActiveCart($userId);
        if (!$cart) {
            $cart = $this->cartRepository->create(['user_id' => $userId]);
            // Reload to get items relation empty
            $cart = $this->cartRepository->getActiveCart($userId);
        }
        return $cart;
    }

    public function addToCart(int $userId, int $feedId, int $quantity)
    {
        $feed = $this->feedRepository->getById($feedId);
        if (!$feed) {
            throw new Exception("Feed not found.");
        }

        if ($feed->quantity < $quantity) {
            throw new Exception("Insufficient stock.");
        }

        $cart = $this->getCart($userId);
        
        // Check if item already exists
        $existingItem = $cart->items->where('feed_id', $feedId)->first();
        
        if ($existingItem) {
            $newQuantity = $existingItem->quantity + $quantity;
            if ($feed->quantity < $newQuantity) {
                throw new Exception("Insufficient stock for requested total.");
            }
            $this->cartRepository->updateItem($existingItem->id, ['quantity' => $newQuantity]);
        } else {
            $this->cartRepository->addItem($cart->id, [
                'feed_id' => $feedId,
                'quantity' => $quantity
            ]);
        }

        return $this->getCart($userId);
    }

    public function updateItemQuantity(int $userId, int $itemId, int $quantity)
    {
        if ($quantity <= 0) {
            return $this->removeItem($userId, $itemId);
        }

        // Verify item belongs to user's cart
        $cart = $this->getCart($userId);
        $item = $cart->items->where('id', $itemId)->first();

        if (!$item) {
            throw new Exception("Item not found in cart.");
        }

        // Check stock
        $feed = $this->feedRepository->getById($item->feed_id);
        if ($feed->quantity < $quantity) {
            throw new Exception("Insufficient stock.");
        }

        $this->cartRepository->updateItem($itemId, ['quantity' => $quantity]);
        return $this->getCart($userId);
    }

    public function removeItem(int $userId, int $itemId)
    {
        $cart = $this->getCart($userId);
        $item = $cart->items->where('id', $itemId)->first();

        if ($item) {
            $this->cartRepository->removeItem($itemId);
        }

        return $this->getCart($userId);
    }

    public function clearCart(int $userId)
    {
        $cart = $this->getCart($userId);
        $this->cartRepository->clearCart($cart->id);
        return $cart;
    }
}

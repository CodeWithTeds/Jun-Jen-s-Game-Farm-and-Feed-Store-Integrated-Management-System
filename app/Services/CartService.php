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

    public function addGameFowlToCart(int $userId, int $gameFowlId)
    {
        $gameFowl = \App\Models\GameFowl::find($gameFowlId);
        if (!$gameFowl) {
            throw new Exception("Game Fowl not found.");
        }

        if ($gameFowl->sale_status !== 'for_sale') {
            throw new Exception("Game Fowl is not for sale.");
        }

        $cart = $this->getCart($userId);

        // Check if item already exists
        $existingItem = $cart->items->where('game_fowl_id', $gameFowlId)->first();
        if ($existingItem) {
            throw new Exception("This game fowl is already in your cart.");
        }

        $this->cartRepository->addItem($cart->id, [
            'game_fowl_id' => $gameFowlId,
            'quantity' => 1
        ]);

        return $this->getCart($userId);
    }

    public function addItem($cartId, array $data)
    {
        return \App\Models\CartItem::create(array_merge(['cart_id' => $cartId], $data));
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

        if ($item->game_fowl_id) {
            // Game fowls can only have quantity 1
            if ($quantity > 1) {
                throw new Exception("Game fowls can only be purchased one at a time.");
            }
            return $this->getCart($userId);
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

<?php

namespace App\Repositories\Eloquent;

use App\Models\Cart;
use App\Models\CartItem;
use App\Repositories\Contracts\CartRepositoryInterface;

class CartRepository implements CartRepositoryInterface
{
    public function getActiveCart(int $userId)
    {
        return Cart::with(['items.feed'])->where('user_id', $userId)->where('status', 'active')->first();
    }

    public function create(array $data)
    {
        return Cart::create($data);
    }

    public function update(int $id, array $data)
    {
        $cart = Cart::find($id);
        if ($cart) {
            $cart->update($data);
            return $cart;
        }
        return null;
    }

    public function delete(int $id)
    {
        return Cart::destroy($id);
    }

    public function addItem(int $cartId, array $data)
    {
        $data['cart_id'] = $cartId;
        return CartItem::create($data);
    }

    public function updateItem(int $itemId, array $data)
    {
        $item = CartItem::find($itemId);
        if ($item) {
            $item->update($data);
            return $item;
        }
        return null;
    }

    public function removeItem(int $itemId)
    {
        return CartItem::destroy($itemId);
    }

    public function clearCart(int $cartId)
    {
        return CartItem::where('cart_id', $cartId)->delete();
    }
}

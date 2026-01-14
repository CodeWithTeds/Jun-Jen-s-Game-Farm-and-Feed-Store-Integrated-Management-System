<?php

namespace App\Repositories\Contracts;

interface CartRepositoryInterface
{
    public function getActiveCart(int $userId);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
    public function addItem(int $cartId, array $data);
    public function updateItem(int $itemId, array $data);
    public function removeItem(int $itemId);
    public function clearCart(int $cartId);
}

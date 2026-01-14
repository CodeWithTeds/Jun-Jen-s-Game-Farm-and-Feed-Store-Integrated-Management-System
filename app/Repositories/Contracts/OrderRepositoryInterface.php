<?php

namespace App\Repositories\Contracts;

interface OrderRepositoryInterface
{
    public function create(array $data);
    public function createItem(array $data);
    public function getById(int $id);
    public function getByUserId(int $userId);
}

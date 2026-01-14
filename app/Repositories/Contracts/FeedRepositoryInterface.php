<?php

namespace App\Repositories\Contracts;

interface FeedRepositoryInterface
{
    public function getAll(array $filters = [], int $perPage = 10);
    public function getById($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function getFeedTypes();
}

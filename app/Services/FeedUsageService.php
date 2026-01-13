<?php

namespace App\Services;

use App\Repositories\Contracts\FeedUsageRepositoryInterface;
use App\Repositories\Contracts\FeedRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Exception;

class FeedUsageService
{
    protected $feedUsageRepository;
    protected $feedRepository;

    public function __construct(
        FeedUsageRepositoryInterface $feedUsageRepository,
        FeedRepositoryInterface $feedRepository
    ) {
        $this->feedUsageRepository = $feedUsageRepository;
        $this->feedRepository = $feedRepository;
    }

    public function getAllFeedUsages(array $filters = [])
    {
        return $this->feedUsageRepository->getAll($filters);
    }

    public function recordUsage(array $data)
    {
        return DB::transaction(function () use ($data) {
            $feed = $this->feedRepository->getById($data['feed_id']);

            if (!$feed) {
                throw new Exception("Feed not found.");
            }

            if ($feed->quantity < $data['quantity']) {
                throw new Exception("Insufficient stock. Available: {$feed->quantity} {$feed->unit}");
            }

            // Create usage record
            $usage = $this->feedUsageRepository->create($data);

            // Deduct stock
            $newQuantity = $feed->quantity - $data['quantity'];
            $updateData = ['quantity' => $newQuantity];

            $this->feedRepository->update($feed->id, $updateData);

            return $usage;
        });
    }
}

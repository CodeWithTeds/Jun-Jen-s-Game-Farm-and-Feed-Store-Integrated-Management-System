<?php

namespace App\Services;

use App\Repositories\Contracts\FeedRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FeedService
{
    protected $feedRepository;

    public function __construct(FeedRepositoryInterface $feedRepository)
    {
        $this->feedRepository = $feedRepository;
    }

    public function getAllFeeds(array $filters = [], int $perPage = 10)
    {
        return $this->feedRepository->getAll($filters, $perPage);
    }

    public function getFeedById($id)
    {
        return $this->feedRepository->getById($id);
    }

    public function createFeed(array $data)
    {
        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            $data['image'] = $data['image']->store('feeds', 'public');
        }

        return $this->feedRepository->create($data);
    }

    public function updateFeed($id, array $data)
    {
        $feed = $this->feedRepository->getById($id);

        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            // Delete old image if exists
            if ($feed->image) {
                Storage::disk('public')->delete($feed->image);
            }
            $data['image'] = $data['image']->store('feeds', 'public');
        }

        return $this->feedRepository->update($id, $data);
    }

    public function deleteFeed($id)
    {
        $feed = $this->feedRepository->getById($id);

        if ($feed->image) {
            Storage::disk('public')->delete($feed->image);
        }

        return $this->feedRepository->delete($id);
    }
}

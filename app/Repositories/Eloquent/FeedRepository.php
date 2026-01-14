<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\FeedRepositoryInterface;
use App\Models\Feed;
use Illuminate\Pagination\LengthAwarePaginator;

class FeedRepository implements FeedRepositoryInterface
{
    public function getAll(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        $query = Feed::query();

        if (isset($filters['search'])) {
            $query->where(function($q) use ($filters) {
                $q->where('feed_name', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('brand', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('batch_number', 'like', '%' . $filters['search'] . '%');
            });
        }

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['is_displayed'])) {
            $query->where('is_displayed', $filters['is_displayed']);
        }

        if (isset($filters['feed_type'])) {
            $query->where('feed_type', $filters['feed_type']);
        }

        return $query->latest()->paginate($perPage);
    }

    public function getById($id): ?Feed
    {
        return Feed::find($id);
    }

    public function create(array $data): Feed
    {
        return Feed::create($data);
    }

    public function update($id, array $data): bool
    {
        $feed = Feed::find($id);
        if ($feed) {
            return $feed->update($data);
        }
        return false;
    }

    public function delete($id): bool
    {
        $feed = Feed::find($id);
        if ($feed) {
            return $feed->delete();
        }
        return false;
    }

    public function getFeedTypes(): array
    {
        return Feed::distinct('feed_type')->pluck('feed_type')->toArray();
    }
}

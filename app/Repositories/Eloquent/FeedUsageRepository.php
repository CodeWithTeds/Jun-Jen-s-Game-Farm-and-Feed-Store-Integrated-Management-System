<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\FeedUsageRepositoryInterface;
use App\Models\FeedUsage;
use Illuminate\Pagination\LengthAwarePaginator;

class FeedUsageRepository implements FeedUsageRepositoryInterface
{
    public function getAll(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        $query = FeedUsage::query()->with(['feed', 'chickRearing']);

        if (isset($filters['search'])) {
             $search = $filters['search'];
             $query->whereHas('feed', function($q) use ($search) {
                 $q->where('feed_name', 'like', "%{$search}%");
             })->orWhereHas('chickRearing', function($q) use ($search) {
                 $q->where('chick_tag_id', 'like', "%{$search}%");
             });
        }

        if (isset($filters['feed_id']) && $filters['feed_id']) {
            $query->where('feed_id', $filters['feed_id']);
        }

        if (isset($filters['chick_rearing_id']) && $filters['chick_rearing_id']) {
            $query->where('chick_rearing_id', $filters['chick_rearing_id']);
        }

        if (isset($filters['date_from']) && $filters['date_from']) {
            $query->whereDate('used_date', '>=', $filters['date_from']);
        }

        if (isset($filters['date_to']) && $filters['date_to']) {
            $query->whereDate('used_date', '<=', $filters['date_to']);
        }

        return $query->latest()->paginate($perPage);
    }

    public function getById($id): ?FeedUsage
    {
        return FeedUsage::with(['feed', 'chickRearing'])->find($id);
    }

    public function create(array $data): FeedUsage
    {
        return FeedUsage::create($data);
    }

    public function update($id, array $data): bool
    {
        $feedUsage = FeedUsage::find($id);
        if ($feedUsage) {
            return $feedUsage->update($data);
        }
        return false;
    }

    public function delete($id): bool
    {
        $feedUsage = FeedUsage::find($id);
        if ($feedUsage) {
            return $feedUsage->delete();
        }
        return false;
    }
}

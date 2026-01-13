<?php

namespace App\Observers;

use App\Models\Feed;

class FeedObserver
{
    /**
     * Handle the Feed "saving" event.
     *
     * @param  \App\Models\Feed  $feed
     * @return void
     */
    public function saving(Feed $feed)
    {
        // Check if the status is 'Expired', if so, we might want to preserve it.
        // Assuming 'Expired' is a terminal state that shouldn't be automatically reverted.
        if ($feed->status === 'Expired') {
            return;
        }

        // Automatic status update based on quantity
        // Low stock threshold is 10
        if ($feed->quantity <= 10) {
            $feed->status = 'Low Stock';
        } elseif ($feed->quantity > 10) {
            // Only update to 'In Stock' if it's currently 'Low Stock' or being created/updated
            // If the status is something else like 'Discontinued', we might not want to touch it.
            // But usually 'In Stock' is the default for good quantity.
            // Let's assume if it's not Expired, it should be In Stock if > 10.
            
            // However, to be safe, if it was 'Low Stock', set to 'In Stock'.
            // If it was 'In Stock', keep it.
            // If it was 'Active', maybe change to 'In Stock'? 
            // The user didn't specify other statuses.
            // Let's force 'In Stock' for > 10 unless it's Expired.
            $feed->status = 'In Stock';
        }
    }
}

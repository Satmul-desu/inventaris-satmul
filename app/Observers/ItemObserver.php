<?php

namespace App\Observers;

use App\Models\Item;
use Illuminate\Support\Facades\Cache;

class ItemObserver
{
    /**
     * Handle the Item "created" event.
     */
    public function created(Item $item): void
    {
        $this->clearDashboardCache();
    }

    /**
     * Handle the Item "updated" event.
     */
    public function updated(Item $item): void
    {
        $this->clearDashboardCache();
    }

    /**
     * Handle the Item "deleted" event.
     */
    public function deleted(Item $item): void
    {
        $this->clearDashboardCache();
    }

    /**
     * Handle the Item "restored" event.
     */
    public function restored(Item $item): void
    {
        $this->clearDashboardCache();
    }

    /**
     * Handle the Item "force deleted" event.
     */
    public function forceDeleted(Item $item): void
    {
        $this->clearDashboardCache();
    }

    /**
     * Clear all dashboard-related cache keys.
     */
    public function clearDashboardCache(): void
    {
        // Clear ALL Laravel cache to ensure dashboard shows correct data
        // This is a more aggressive approach to fix the "0" display issue
        try {
            \Illuminate\Support\Facades\Cache::flush();
        } catch (\Exception $e) {
            // If flush fails, at least try to forget specific keys
            Cache::forget('user.dashboard.items');
            Cache::forget('user.dashboard.notifications');
            Cache::forget('user.dashboard.low_stock_count');
        }
    }
}

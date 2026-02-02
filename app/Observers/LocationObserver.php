<?php

namespace App\Observers;

use App\Models\Location;
use Illuminate\Support\Facades\Cache;

class LocationObserver
{
    /**
     * Handle the Location "created" event.
     */
    public function created(Location $location): void
    {
        $this->clearDashboardCache();
    }

    /**
     * Handle the Location "updated" event.
     */
    public function updated(Location $location): void
    {
        $this->clearDashboardCache();
    }

    /**
     * Handle the Location "deleted" event.
     */
    public function deleted(Location $location): void
    {
        $this->clearDashboardCache();
    }

    /**
     * Handle the Location "restored" event.
     */
    public function restored(Location $location): void
    {
        $this->clearDashboardCache();
    }

    /**
     * Handle the Location "force deleted" event.
     */
    public function forceDeleted(Location $location): void
    {
        $this->clearDashboardCache();
    }

    /**
     * Clear all dashboard-related cache keys.
     */
    public function clearDashboardCache(): void
    {
        // Clear ALL cache to ensure dashboard shows correct data
        try {
            Cache::flush();
        } catch (\Exception $e) {
            // Fallback: forget specific keys
            Cache::forget('user.dashboard.items');
            Cache::forget('user.dashboard.notifications');
            Cache::forget('user.dashboard.low_stock_count');
        }
    }
}


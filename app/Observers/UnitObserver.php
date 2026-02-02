<?php

namespace App\Observers;

use App\Models\Unit;
use Illuminate\Support\Facades\Cache;

class UnitObserver
{
    /**
     * Handle the Unit "created" event.
     */
    public function created(Unit $unit): void
    {
        $this->clearDashboardCache();
    }

    /**
     * Handle the Unit "updated" event.
     */
    public function updated(Unit $unit): void
    {
        $this->clearDashboardCache();
    }

    /**
     * Handle the Unit "deleted" event.
     */
    public function deleted(Unit $unit): void
    {
        $this->clearDashboardCache();
    }

    /**
     * Handle the Unit "restored" event.
     */
    public function restored(Unit $unit): void
    {
        $this->clearDashboardCache();
    }

    /**
     * Handle the Unit "force deleted" event.
     */
    public function forceDeleted(Unit $unit): void
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


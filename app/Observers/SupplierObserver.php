<?php

namespace App\Observers;

use App\Models\Supplier;
use Illuminate\Support\Facades\Cache;

class SupplierObserver
{
    /**
     * Handle the Supplier "created" event.
     */
    public function created(Supplier $supplier): void
    {
        $this->clearDashboardCache();
    }

    /**
     * Handle the Supplier "updated" event.
     */
    public function updated(Supplier $supplier): void
    {
        $this->clearDashboardCache();
    }

    /**
     * Handle the Supplier "deleted" event.
     */
    public function deleted(Supplier $supplier): void
    {
        $this->clearDashboardCache();
    }

    /**
     * Handle the Supplier "restored" event.
     */
    public function restored(Supplier $supplier): void
    {
        $this->clearDashboardCache();
    }

    /**
     * Handle the Supplier "force deleted" event.
     */
    public function forceDeleted(Supplier $supplier): void
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


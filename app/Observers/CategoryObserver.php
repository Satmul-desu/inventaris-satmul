<?php

namespace App\Observers;

use App\Models\Category;
use Illuminate\Support\Facades\Cache;

class CategoryObserver
{
    /**
     * Handle the Category "created" event.
     */
    public function created(Category $category): void
    {
        $this->clearDashboardCache();
    }

    /**
     * Handle the Category "updated" event.
     */
    public function updated(Category $category): void
    {
        $this->clearDashboardCache();
    }

    /**
     * Handle the Category "deleted" event.
     */
    public function deleted(Category $category): void
    {
        $this->clearDashboardCache();
    }

    /**
     * Handle the Category "restored" event.
     */
    public function restored(Category $category): void
    {
        $this->clearDashboardCache();
    }

    /**
     * Handle the Category "force deleted" event.
     */
    public function forceDeleted(Category $category): void
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


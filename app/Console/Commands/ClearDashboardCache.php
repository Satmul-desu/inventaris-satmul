<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class ClearDashboardCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dashboard:clear-cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear all dashboard-related cache to refresh statistics';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Clearing dashboard cache...');
        
        // Admin dashboard cache keys
        $adminKeys = [
            'dashboard.total_items',
            'dashboard.total_stock',
            'dashboard.low_stock_items',
            'dashboard.out_of_stock_items',
            'dashboard.total_suppliers',
            'dashboard.total_categories',
            'dashboard.total_units',
            'dashboard.total_locations',
            'dashboard.recent_items',
            'dashboard.notifications',
            'dashboard.recent_stock_ins',
            'dashboard.recent_stock_outs',
        ];
        
        // User dashboard cache keys
        $userKeys = [
            'user.dashboard.items',
            'user.dashboard.notifications',
            'user.dashboard.low_stock_count',
        ];
        
        $allKeys = array_merge($adminKeys, $userKeys);
        $clearedCount = 0;
        
        foreach ($allKeys as $key) {
            if (Cache::forget($key)) {
                $clearedCount++;
            }
        }
        
        $this->info("Successfully cleared {$clearedCount} cache keys.");
        $this->info('Dashboard statistics have been refreshed!');
        
        return Command::SUCCESS;
    }
}

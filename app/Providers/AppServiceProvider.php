<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Item;
use App\Models\Category;
use App\Models\Unit;
use App\Models\Location;
use App\Models\Supplier;
use App\Observers\ItemObserver;
use App\Observers\CategoryObserver;
use App\Observers\UnitObserver;
use App\Observers\LocationObserver;
use App\Observers\SupplierObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register observers for all models
        Item::observe(ItemObserver::class);
        Category::observe(CategoryObserver::class);
        Unit::observe(UnitObserver::class);
        Location::observe(LocationObserver::class);
        Supplier::observe(SupplierObserver::class);
    }
}

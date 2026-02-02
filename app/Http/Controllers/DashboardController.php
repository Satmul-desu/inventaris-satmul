<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use App\Models\Notification;
use App\Models\Supplier;
use App\Models\Unit;
use App\Models\Location;
use App\Models\StockIn;
use App\Models\StockOut;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    /**
     * Display admin dashboard.
     */
    public function admin()
    {
        try {
            // Get data directly without cache to ensure real-time data
            // Cache is cleared via observers when data changes
            $totalItems = Item::count();

            $totalStock = Item::sum('stock');

            $lowStockItems = Item::where('stock', '>', 0)
                ->whereRaw('stock <= min_stock')
                ->count();

            $outOfStockItems = Item::where('stock', '<=', 0)->count();

            $totalSuppliers = Supplier::count();

            $totalCategories = Category::count();

            $totalUnits = Unit::count();

            $totalLocations = Location::count();

            // Recent items
            $recentItems = Item::with(['category', 'unit'])
                ->latest()
                ->take(5)
                ->get();

            // Low stock notifications
            $notifications = Notification::with('item')
                ->where('is_read', false)
                ->latest()
                ->take(5)
                ->get();

            // Recent stock activities
            $recentStockIns = StockIn::with(['item', 'user'])
                ->latest()
                ->take(5)
                ->get();

            $recentStockOuts = StockOut::with(['item', 'user'])
                ->latest()
                ->take(5)
                ->get();
        } catch (\Exception $e) {
            // Tables might not exist yet during migration
            $totalItems = 0;
            $totalStock = 0;
            $lowStockItems = 0;
            $outOfStockItems = 0;
            $totalSuppliers = 0;
            $totalCategories = 0;
            $totalUnits = 0;
            $totalLocations = 0;
            $recentItems = collect();
            $notifications = collect();
            $recentStockIns = collect();
            $recentStockOuts = collect();
        }

        return view('admin.dashboard', compact(
            'totalItems', 'totalStock', 'lowStockItems', 
            'outOfStockItems', 'totalSuppliers', 'totalCategories',
            'totalUnits', 'totalLocations',
            'recentItems', 'notifications', 'recentStockIns', 'recentStockOuts'
        ));
    }

    /**
     * Display user dashboard.
     * NOTE: Cache DISABLED to ensure real-time data is always displayed correctly.
     * If dashboard shows 0 despite having data, this ensures fresh data every time.
     */
    public function user()
    {
        try {
            // Get data directly WITHOUT cache to ensure real-time data
            // Cache was causing dashboard to show 0 even when items exist
            $items = Item::with(['category', 'unit'])
                ->orderBy('name')
                ->get();

            $notifications = Notification::with('item')
                ->where('is_read', false)
                ->latest()
                ->take(5)
                ->get();

            $lowStockCount = Item::where('stock', '>', 0)
                ->whereRaw('stock <= min_stock')
                ->count();
        } catch (\Exception $e) {
            // Log error for debugging
            \Log::error('User dashboard error: ' . $e->getMessage());
            
            $items = collect();
            $notifications = collect();
            $lowStockCount = 0;
        }

        return view('user.dashboard', compact('items', 'notifications', 'lowStockCount'));
    }

    /**
     * Redirect based on role.
     */
    public function index()
    {
        if (Auth::user()->isOwner()) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('user.dashboard');
    }
}


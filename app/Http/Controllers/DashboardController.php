<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use App\Models\Notification;
use App\Models\Supplier;
use App\Models\Unit;
use App\Models\Location;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display admin dashboard.
     */
    public function admin()
    {
        try {
            $totalItems = Item::count();
            $totalStock = Item::sum('stock');

            $lowStockItems = Item::where('stock', '>', 0)
                ->whereColumn('stock', '<=', 'min_stock')
                ->count();

            $outOfStockItems = Item::where('stock', '<=', 0)->count();

            $totalSuppliers = Supplier::count();
            $totalCategories = Category::count();
            $totalUnits = Unit::count();
            $totalLocations = Location::count();

            $recentItems = Item::with(['category', 'unit'])
                ->latest()
                ->take(5)
                ->get();

            $notifications = Notification::with('item')
                ->where('is_read', false)
                ->latest()
                ->take(5)
                ->get();

            // Aman walau tabel stock belum ada
            $recentStockIns = collect();
            $recentStockOuts = collect();

        } catch (\Exception $e) {
            dd($e); // tampilkan error asli kalau ada
        }

        return view('admin.dashboard', compact(
            'totalItems',
            'totalStock',
            'lowStockItems',
            'outOfStockItems',
            'totalSuppliers',
            'totalCategories',
            'totalUnits',
            'totalLocations',
            'recentItems',
            'notifications',
            'recentStockIns',
            'recentStockOuts'
        ));
    }

    /**
     * Display user dashboard.
     */
    public function user()
    {
        try {
            $items = Item::with(['category', 'unit'])
                ->orderBy('name')
                ->get();

            $notifications = Notification::with('item')
                ->where('is_read', false)
                ->latest()
                ->take(5)
                ->get();

            $lowStockCount = Item::where('stock', '>', 0)
                ->whereColumn('stock', '<=', 'min_stock')
                ->count();

        } catch (\Exception $e) {
            dd($e);
        }

        return view('user.dashboard', compact(
            'items',
            'notifications',
            'lowStockCount'
        ));
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

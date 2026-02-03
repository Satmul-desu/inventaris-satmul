<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\Category;
use App\Models\Item;
use App\Models\Notification;
use App\Models\Supplier;
use App\Models\Unit;
use App\Models\Location;
use App\Models\StockIn;
use App\Models\StockOut;
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

            // Data Peminjaman
            $totalBorrowings = Borrowing::count();
            $activeBorrowings = Borrowing::active()->count();
            $overdueBorrowings = Borrowing::overdue()->count();
            $returnedBorrowings = Borrowing::returned()->count();

            $recentItems = Item::with(['category', 'unit'])
                ->latest()
                ->take(5)
                ->get();

            $notifications = Notification::with('item')
                ->where('is_read', false)
                ->latest()
                ->take(5)
                ->get();

            // Recent stock in/out dengan aman
            $recentStockIns = StockIn::with(['item', 'user'])
                ->latest()
                ->take(5)
                ->get();

            $recentStockOuts = StockOut::with(['item', 'user'])
                ->latest()
                ->take(5)
                ->get();

            // Recent borrowings
            $recentBorrowings = Borrowing::with(['item', 'user'])
                ->latest()
                ->take(5)
                ->get();

        } catch (\Exception $e) {
            // Fallback jika tabel belum ada
            $totalItems = 0;
            $totalStock = 0;
            $lowStockItems = 0;
            $outOfStockItems = 0;
            $totalSuppliers = 0;
            $totalCategories = 0;
            $totalUnits = 0;
            $totalLocations = 0;
            $totalBorrowings = 0;
            $activeBorrowings = 0;
            $overdueBorrowings = 0;
            $returnedBorrowings = 0;
            $recentItems = collect();
            $notifications = collect();
            $recentStockIns = collect();
            $recentStockOuts = collect();
            $recentBorrowings = collect();
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
            'totalBorrowings',
            'activeBorrowings',
            'overdueBorrowings',
            'returnedBorrowings',
            'recentItems',
            'notifications',
            'recentStockIns',
            'recentStockOuts',
            'recentBorrowings'
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

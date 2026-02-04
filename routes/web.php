<?php

use App\Http\Controllers\Admin\BorrowingController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ItemController as AdminItemController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\SandboxController;
use App\Http\Controllers\Admin\StockInController;
use App\Http\Controllers\Admin\StockOutController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\ItemController;
use Illuminate\Support\Facades\Route;

// Redirect root ke dashboard berdasarkan role
Route::get('/dashboard', function () {
    if (auth()->check()) {
        if (auth()->user()->isOwner() || auth()->user()->isStaff()) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('user.dashboard');
    }
    return redirect()->route('login');
})->middleware(['auth'])->name('dashboard');

Route::get('/', function () {
    if (auth()->check()) {
        if (auth()->user()->isOwner() || auth()->user()->isStaff()) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('user.dashboard');
    }
    return redirect()->route('login');
});

// Dashboard Routes
Route::middleware(['auth', 'is_active'])->group(function () {
    // Admin Routes (Owner and Staff)
    Route::middleware(['role:owner,staff'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');
        
        // SHARED ROUTES (View Only) - Available for both Owner and Staff
        // Items - View Only
        Route::get('items', [AdminItemController::class, 'index'])->name('items.index');
        Route::get('items/{item}', [AdminItemController::class, 'show'])->name('items.show');
        
        // Categories - View Only
        Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::get('categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
        
        // Units - View Only
        Route::get('units', [UnitController::class, 'index'])->name('units.index');
        Route::get('units/{unit}', [UnitController::class, 'show'])->name('units.show');
        
        // Locations - View Only
        Route::get('locations', [LocationController::class, 'index'])->name('locations.index');
        Route::get('locations/{location}', [LocationController::class, 'show'])->name('locations.show');
        
        // Suppliers - View Only
        Route::get('suppliers', [SupplierController::class, 'index'])->name('suppliers.index');
        Route::get('suppliers/{supplier}', [SupplierController::class, 'show'])->name('suppliers.show');
        
        // Stock In - View Only
        Route::get('stock-in', [StockInController::class, 'index'])->name('stock-in.index');
        Route::get('stock-in/{stockIn}', [StockInController::class, 'show'])->name('stock-in.show');
        
        // Stock Out - View Only
        Route::get('stock-out', [StockOutController::class, 'index'])->name('stock-out.index');
        Route::get('stock-out/{stockOut}', [StockOutController::class, 'show'])->name('stock-out.show');
        
        // Borrowings - View Only
        Route::get('borrowings', [BorrowingController::class, 'index'])->name('borrowings.index');
        Route::get('borrowings/{borrowing}', [BorrowingController::class, 'show'])->name('borrowings.show');
        Route::post('borrowings/{borrowing}/return', [BorrowingController::class, 'returnItem'])->name('borrowings.return');
        
        // Notifications - View Only (read and mark as read)
        Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
        Route::get('notifications/count', [NotificationController::class, 'getUnreadCount'])->name('notifications.count');
        Route::get('notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
        Route::get('notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
        
        // Sandbox - View Only
        Route::get('sandbox', [SandboxController::class, 'index'])->name('sandbox.index');
        Route::get('sandbox/status/{status}', [SandboxController::class, 'filterByStatus'])->name('sandbox.filter');
        Route::get('sandbox/{sandbox}', [SandboxController::class, 'show'])->name('sandbox.show');
        
        // OWNER ONLY ROUTES - Create, Edit, Delete
        Route::middleware(['role:owner'])->group(function () {
            // Items CRUD
            Route::get('items/create', [AdminItemController::class, 'create'])->name('items.create');
            Route::post('items', [AdminItemController::class, 'store'])->name('items.store');
            Route::get('items/{item}/edit', [AdminItemController::class, 'edit'])->name('items.edit');
            Route::put('items/{item}', [AdminItemController::class, 'update'])->name('items.update');
            Route::delete('items/{item}', [AdminItemController::class, 'destroy'])->name('items.destroy');
            
            // Categories CRUD
            Route::get('categories/create', [CategoryController::class, 'create'])->name('categories.create');
            Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');
            Route::get('categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
            Route::put('categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
            Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
            
            // Units CRUD
            Route::get('units/create', [UnitController::class, 'create'])->name('units.create');
            Route::post('units', [UnitController::class, 'store'])->name('units.store');
            Route::get('units/{unit}/edit', [UnitController::class, 'edit'])->name('units.edit');
            Route::put('units/{unit}', [UnitController::class, 'update'])->name('units.update');
            Route::delete('units/{unit}', [UnitController::class, 'destroy'])->name('units.destroy');
            
            // Locations CRUD
            Route::get('locations/create', [LocationController::class, 'create'])->name('locations.create');
            Route::post('locations', [LocationController::class, 'store'])->name('locations.store');
            Route::get('locations/{location}/edit', [LocationController::class, 'edit'])->name('locations.edit');
            Route::put('locations/{location}', [LocationController::class, 'update'])->name('locations.update');
            Route::delete('locations/{location}', [LocationController::class, 'destroy'])->name('locations.destroy');
            
            // Suppliers CRUD
            Route::get('suppliers/create', [SupplierController::class, 'create'])->name('suppliers.create');
            Route::post('suppliers', [SupplierController::class, 'store'])->name('suppliers.store');
            Route::get('suppliers/{supplier}/edit', [SupplierController::class, 'edit'])->name('suppliers.edit');
            Route::put('suppliers/{supplier}', [SupplierController::class, 'update'])->name('suppliers.update');
            Route::delete('suppliers/{supplier}', [SupplierController::class, 'destroy'])->name('suppliers.destroy');
            
            // Stock In CRUD
            Route::get('stock-in/create', [StockInController::class, 'create'])->name('stock-in.create');
            Route::post('stock-in', [StockInController::class, 'store'])->name('stock-in.store');
            Route::get('stock-in/{stockIn}/edit', [StockInController::class, 'edit'])->name('stock-in.edit');
            Route::put('stock-in/{stockIn}', [StockInController::class, 'update'])->name('stock-in.update');
            Route::delete('stock-in/{stockIn}', [StockInController::class, 'destroy'])->name('stock-in.destroy');
            
            // Stock Out CRUD
            Route::get('stock-out/create', [StockOutController::class, 'create'])->name('stock-out.create');
            Route::post('stock-out', [StockOutController::class, 'store'])->name('stock-out.store');
            Route::get('stock-out/{stockOut}/edit', [StockOutController::class, 'edit'])->name('stock-out.edit');
            Route::put('stock-out/{stockOut}', [StockOutController::class, 'update'])->name('stock-out.update');
            Route::delete('stock-out/{stockOut}', [StockOutController::class, 'destroy'])->name('stock-out.destroy');
            
            // Borrowings CRUD
            Route::get('borrowings/create', [BorrowingController::class, 'create'])->name('borrowings.create');
            Route::post('borrowings', [BorrowingController::class, 'store'])->name('borrowings.store');
            Route::get('borrowings/{borrowing}/edit', [BorrowingController::class, 'edit'])->name('borrowings.edit');
            Route::put('borrowings/{borrowing}', [BorrowingController::class, 'update'])->name('borrowings.update');
            Route::delete('borrowings/{borrowing}', [BorrowingController::class, 'destroy'])->name('borrowings.destroy');
            
            // Notifications CRUD (create, delete, clear all)
            Route::get('notifications/create', [NotificationController::class, 'create'])->name('notifications.create');
            Route::post('notifications', [NotificationController::class, 'store'])->name('notifications.store');
            Route::delete('notifications/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
            Route::delete('notifications/clear-all', [NotificationController::class, 'clearAll'])->name('notifications.clear-all');
            
            // Sandbox CRUD (store, reply, close, reopen, destroy)
            Route::post('sandbox', [SandboxController::class, 'store'])->name('sandbox.store');
            Route::post('sandbox/{sandbox}/reply', [SandboxController::class, 'reply'])->name('sandbox.reply');
            Route::post('sandbox/{sandbox}/quick-reply', [SandboxController::class, 'quickReply'])->name('sandbox.quick-reply');
            Route::get('sandbox/{sandbox}/pin', [SandboxController::class, 'togglePin'])->name('sandbox.pin');
            Route::get('sandbox/{sandbox}/close', [SandboxController::class, 'close'])->name('sandbox.close');
            Route::get('sandbox/{sandbox}/reopen', [SandboxController::class, 'reopen'])->name('sandbox.reopen');
            Route::delete('sandbox/{sandbox}', [SandboxController::class, 'destroy'])->name('sandbox.destroy');
            
            // User Management - Owner ONLY
            Route::resource('users', UserController::class);
            Route::get('users/{user}/toggle-active', [UserController::class, 'toggleActive'])->name('users.toggle-active');
        });
    });

    // Simple User Routes (Basic access - kept for backward compatibility)
    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'user'])->name('dashboard');
        Route::get('/items', [ItemController::class, 'index'])->name('items.index');
    });
});

require __DIR__.'/auth.php';


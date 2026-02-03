<?php

use App\Http\Controllers\Admin\BorrowingController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ItemController as AdminItemController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\StockInController;
use App\Http\Controllers\Admin\StockOutController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\User\ItemController;
use Illuminate\Support\Facades\Route;

// Redirect root ke dashboard berdasarkan role
Route::get('/dashboard', function () {
    if (auth()->check()) {
        if (auth()->user()->isOwner()) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('user.dashboard');
    }
    return redirect()->route('login');
})->middleware(['auth'])->name('dashboard');

Route::get('/', function () {
    if (auth()->check()) {
        if (auth()->user()->isOwner()) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('user.dashboard');
    }
    return redirect()->route('login');
});

// Dashboard Routes
Route::middleware(['auth', 'is_active'])->group(function () {
    // Admin Routes (Owner only)
    Route::middleware(['role:owner'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');
        
        // Resources
        Route::resource('items', AdminItemController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('units', UnitController::class);
        Route::resource('locations', LocationController::class);
        Route::resource('suppliers', SupplierController::class);
        Route::resource('stock-in', StockInController::class);
        Route::resource('stock-out', StockOutController::class);
        Route::resource('borrowings', BorrowingController::class);
        Route::post('borrowings/{borrowing}/return', [BorrowingController::class, 'returnItem'])->name('borrowings.return');
        Route::resource('users', UserController::class);
        
        // Notifications
        Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
        Route::get('notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
        Route::get('notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
        Route::delete('notifications/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
        Route::delete('notifications/clear-all', [NotificationController::class, 'clearAll'])->name('notifications.clear-all');
        
        // User Actions
        Route::get('users/{user}/toggle-active', [UserController::class, 'toggleActive'])->name('users.toggle-active');
    });

    // User Routes (Staff)
    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'user'])->name('dashboard');
        Route::get('/items', [ItemController::class, 'index'])->name('items.index');
    });
});

require __DIR__.'/auth.php';


<?php

namespace App\Http\Controllers\Admin;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display a listing of notifications.
     */
    public function index()
    {
        $notifications = Notification::with(['item'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.notifications.index', compact('notifications'));
    }

    /**
     * Mark notification as read.
     */
    public function markAsRead(Notification $notification)
    {
        $notification->markAsRead();
        return back()->with('success', 'Notifikasi ditandai sudah dibaca.');
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead()
    {
        Notification::where('is_read', false)->update(['is_read' => true]);
        return back()->with('success', 'Semua notifikasi ditandai sudah dibaca.');
    }

    /**
     * Delete notification.
     */
    public function destroy(Notification $notification)
    {
        $notification->delete();
        return back()->with('success', 'Notifikasi dihapus.');
    }

    /**
     * Clear all notifications.
     */
    public function clearAll()
    {
        Notification::truncate();
        return back()->with('success', 'Semua notifikasi dihapus.');
    }
}


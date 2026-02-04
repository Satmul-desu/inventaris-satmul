<?php

namespace App\Http\Controllers\Admin;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('role:owner')->only(['create', 'store', 'destroy', 'clearAll']);
    }

    /**
     * Display a listing of notifications.
     */
    public function index(Request $request)
    {
        $query = Notification::with(['item', 'sender'])
            ->orderBy('created_at', 'desc');

        // Filter by read status
        if ($request->has('filter')) {
            if ($request->filter === 'unread') {
                $query->where('is_read', false);
            } elseif ($request->filter === 'read') {
                $query->where('is_read', true);
            }
        }

        // Filter by type
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        $notifications = $query->paginate(15);
        $unreadCount = Notification::unread()->count();

        return view('admin.notifications.index', compact('notifications', 'unreadCount'));
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

    /**
     * Store a new manual notification.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
            'user_id' => 'nullable|exists:users,id',
            'type' => 'nullable|string|max:50',
            'priority' => 'nullable|in:low,normal,high'
        ]);

        Notification::create([
            'sender_id' => Auth::id(),
            'user_id' => $request->user_id,
            'title' => $request->title,
            'message' => $request->message,
            'type' => $request->type ?? 'manual',
            'priority' => $request->priority ?? 'normal',
            'is_read' => false
        ]);

        return redirect()->route('admin.notifications.index')
            ->with('success', 'Notifikasi berhasil dibuat.');
    }

    /**
     * Show create notification form.
     */
    public function create()
    {
        $users = User::where('id', '!=', Auth::id())->get();
        return view('admin.notifications.create', compact('users'));
    }

    /**
     * Get unread count (API endpoint for AJAX).
     */
    public function getUnreadCount()
    {
        $count = Notification::unread()->count();
        return response()->json(['count' => $count]);
    }
}


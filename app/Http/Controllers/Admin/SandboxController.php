<?php

namespace App\Http\Controllers\Admin;

use App\Models\Sandbox;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SandboxController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('role:owner')->only(['store', 'reply', 'togglePin', 'close', 'reopen', 'destroy', 'quickReply']);
    }

    /**
     * Display a listing of sandbox messages (Q&A).
     */
    public function index()
    {
        // Get threads (messages without parent)
        $threads = Sandbox::with(['sender'])
            ->whereNull('parent_id')
            ->orderBy('is_pinned', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Get unread count
        $unreadCount = Sandbox::where('type', 'question')
            ->where('status', 'open')
            ->whereNull('parent_id')
            ->count();

        return view('admin.sandbox.index', compact('threads', 'unreadCount'));
    }

    /**
     * Display messages by status.
     */
    public function filterByStatus($status)
    {
        $threads = Sandbox::with(['sender'])
            ->whereNull('parent_id')
            ->where('status', $status)
            ->orderBy('is_pinned', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $unreadCount = Sandbox::where('type', 'question')
            ->where('status', 'open')
            ->whereNull('parent_id')
            ->count();

        return view('admin.sandbox.index', compact('threads', 'unreadCount', 'status'));
    }

    /**
     * Store a new question/thread.
     */
    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:5000',
            'priority' => 'nullable|in:low,normal,high'
        ]);

        Sandbox::create([
            'sender_id' => Auth::id(),
            'subject' => $request->subject,
            'message' => $request->message,
            'type' => 'question',
            'priority' => $request->priority ?? 'normal',
            'status' => 'open',
            'parent_id' => null
        ]);

        return redirect()->route('admin.sandbox.index')
            ->with('success', 'Pertanyaan berhasil dikirim.');
    }

    /**
     * Reply to a question (create answer).
     */
    public function reply(Request $request, Sandbox $sandbox)
    {
        $request->validate([
            'message' => 'required|string|max:5000'
        ]);

        // Create the reply
        $reply = Sandbox::create([
            'sender_id' => Auth::id(),
            'subject' => null,
            'message' => $request->message,
            'type' => 'answer',
            'parent_id' => $sandbox->id,
            'status' => $sandbox->status
        ]);

        // Mark original question as answered
        if ($sandbox->status === 'open') {
            $sandbox->markAsAnswered();
        }

        return redirect()->route('admin.sandbox.show', $sandbox->id)
            ->with('success', 'Jawaban berhasil dikirim.');
    }

    /**
     * Show a single thread with all replies.
     */
    public function show(Sandbox $sandbox)
    {
        // Load the thread with replies and sender
        $sandbox->load(['sender', 'replies.sender']);

        return view('admin.sandbox.show', compact('sandbox'));
    }

    /**
     * Pin/Unpin a message.
     */
    public function togglePin(Sandbox $sandbox)
    {
        $sandbox->update(['is_pinned' => !$sandbox->is_pinned]);
        
        $message = $sandbox->is_pinned ? 'Pesan dipin.' : 'Pin dihapus.';
        return back()->with('success', $message);
    }

    /**
     * Close a thread.
     */
    public function close(Sandbox $sandbox)
    {
        $sandbox->update(['status' => 'closed']);
        return back()->with('success', 'Thread ditutup.');
    }

    /**
     * Reopen a thread.
     */
    public function reopen(Sandbox $sandbox)
    {
        $sandbox->update(['status' => 'open']);
        return back()->with('success', 'Thread dibuka kembali.');
    }

    /**
     * Delete a message or reply.
     */
    public function destroy(Sandbox $sandbox)
    {
        // If it's a parent, delete all replies first
        if ($sandbox->parent_id === null) {
            Sandbox::where('parent_id', $sandbox->id)->delete();
        }
        
        $sandbox->delete();
        return redirect()->route('admin.sandbox.index')
            ->with('success', 'Pesan dihapus.');
    }

    /**
     * Quick answer (AJAX endpoint).
     */
    public function quickReply(Request $request, Sandbox $sandbox)
    {
        $request->validate([
            'message' => 'required|string|max:5000'
        ]);

        Sandbox::create([
            'sender_id' => Auth::id(),
            'subject' => null,
            'message' => $request->message,
            'type' => 'answer',
            'parent_id' => $sandbox->id,
            'status' => 'answered'
        ]);

        $sandbox->markAsAnswered();

        return response()->json(['success' => true]);
    }
}


<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sandbox extends Model
{
    use HasFactory;

    protected $table = 'sandbox';

    protected $fillable = [
        'sender_id',
        'subject',
        'message',
        'type',
        'priority',
        'status',
        'parent_id',
        'is_pinned'
    ];

    /**
     * Get the user who sent the message.
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Get the parent message (for replies).
     */
    public function parent()
    {
        return $this->belongsTo(Sandbox::class, 'parent_id');
    }

    /**
     * Get the replies to this message.
     */
    public function replies()
    {
        return $this->hasMany(Sandbox::class, 'parent_id')->orderBy('created_at', 'asc');
    }

    /**
     * Get the main thread (root message).
     */
    public function thread()
    {
        return $this->belongsTo(Sandbox::class, 'parent_id');
    }

    /**
     * Scope for unanswered questions.
     */
    public function scopeUnanswered($query)
    {
        return $query->where('type', 'question')
                     ->where('status', 'open')
                     ->whereNull('parent_id');
    }

    /**
     * Scope for threads.
     */
    public function scopeThreads($query)
    {
        return $query->whereNull('parent_id')->orderBy('created_at', 'desc');
    }

    /**
     * Mark as answered.
     */
    public function markAsAnswered(): void
    {
        $this->update(['status' => 'answered']);
    }

    /**
     * Close the thread.
     */
    public function close(): void
    {
        $this->update(['status' => 'closed']);
    }
}


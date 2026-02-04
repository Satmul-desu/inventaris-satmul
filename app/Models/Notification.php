<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id', 
        'sender_id',
        'user_id',
        'type', 
        'title',
        'message', 
        'is_read',
        'priority'
    ];

    /**
     * Get the item that owns the notification.
     */
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    /**
     * Get the sender of the notification.
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Get the user who receives the notification.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Mark notification as read.
     */
    public function markAsRead(): void
    {
        $this->update(['is_read' => true]);
    }

    /**
     * Scope for unread notifications.
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Scope for notifications by type.
     */
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Get high priority notifications.
     */
    public function scopeHighPriority($query)
    {
        return $query->where('priority', 'high')->orWhere('priority', 'normal');
    }
}


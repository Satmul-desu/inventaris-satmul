<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = ['item_id', 'type', 'message', 'is_read'];

    /**
     * Get the item that owns the notification.
     */
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    /**
     * Mark notification as read.
     */
    public function markAsRead(): void
    {
        $this->update(['is_read' => true]);
    }
}


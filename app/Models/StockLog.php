<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id', 'action', 'qty', 'previous_stock', 
        'current_stock', 'user_id', 'description'
    ];

    protected $casts = [
        'qty' => 'integer',
        'previous_stock' => 'integer',
        'current_stock' => 'integer',
        'date' => 'date',
    ];

    /**
     * Get the item that owns the stock log.
     */
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    /**
     * Get the user that created the stock log.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get action badge color.
     */
    public function getActionBadgeAttribute(): string
    {
        $colors = [
            'IN' => 'success',
            'OUT' => 'danger',
            'ADJUST' => 'warning',
            'TRANSFER' => 'info',
        ];
        $color = $colors[$this->action] ?? 'secondary';
        return '<span class="badge badge-'.$color.'">'.$this->action.'</span>';
    }
}


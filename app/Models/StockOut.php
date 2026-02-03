<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockOut extends Model
{
    use HasFactory;

    protected $fillable = ['item_id', 'location_id', 'qty', 'date', 'recipient', 'note', 'user_id'];

    protected $casts = [
        'date' => 'datetime',
    ];

    /**
     * Get the item that owns the stock out.
     */
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    /**
     * Get the location that owns the stock out.
     */
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * Get the user that created the stock out.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}


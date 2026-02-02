<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemLocation extends Model
{
    use HasFactory;

    protected $fillable = ['item_id', 'location_id', 'qty'];

    /**
     * Get the item that owns the item location.
     */
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    /**
     * Get the location that owns the item location.
     */
    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}


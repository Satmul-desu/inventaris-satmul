<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockIn extends Model
{
    use HasFactory;

    protected $fillable = ['item_id', 'supplier_id', 'qty', 'date', 'note', 'user_id'];

    protected $casts = [
        'date' => 'datetime',
    ];

    /**
     * Get the item that owns the stock in.
     */
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    /**
     * Get the supplier that owns the stock in.
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    /**
     * Get the user that created the stock in.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}


<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();
        self::observe(\App\Observers\ItemObserver::class);
    }

    protected $fillable = [
        'code', 'name', 'category_id', 'unit_id', 
        'stock', 'min_stock', 'description'
    ];

    /**
     * Get the category that owns the item.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the unit that owns the item.
     */
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    /**
     * Get the stock ins for this item.
     */
    public function stockIns()
    {
        return $this->hasMany(StockIn::class);
    }

    /**
     * Get the stock outs for this item.
     */
    public function stockOuts()
    {
        return $this->hasMany(StockOut::class);
    }

    /**
     * Get the item locations for this item.
     */
    public function itemLocations()
    {
        return $this->hasMany(ItemLocation::class);
    }

    /**
     * Get the stock logs for this item.
     */
    public function stockLogs()
    {
        return $this->hasMany(StockLog::class);
    }

    /**
     * Get the notifications for this item.
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    /**
     * Check if stock is low.
     */
    public function isLowStock(): bool
    {
        return $this->stock <= $this->min_stock && $this->stock > 0;
    }

    /**
     * Check if stock is out.
     */
    public function isOutOfStock(): bool
    {
        return $this->stock <= 0;
    }

    /**
     * Get status badge.
     */
    public function getStatusBadgeAttribute(): string
    {
        if ($this->isOutOfStock()) {
            return '<span class="badge badge-danger">Habis</span>';
        } elseif ($this->isLowStock()) {
            return '<span class="badge badge-warning">Menipis</span>';
        }
        return '<span class="badge badge-success">Tersedia</span>';
    }
}


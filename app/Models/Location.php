<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    /**
     * Get the item locations for this location.
     */
    public function itemLocations()
    {
        return $this->hasMany(ItemLocation::class);
    }

    /**
     * Get the stock outs for this location.
     */
    public function stockOuts()
    {
        return $this->hasMany(StockOut::class);
    }
}


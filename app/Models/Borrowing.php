<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id', 'borrower_name', 'borrower_phone', 'qty',
        'borrow_date', 'return_date', 'actual_return_date',
        'status', 'note', 'return_note', 'user_id'
    ];

    protected $casts = [
        'borrow_date' => 'date',
        'return_date' => 'date',
        'actual_return_date' => 'date',
    ];

    /**
     * Get the item that was borrowed.
     */
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    /**
     * Get the user who processed the borrowing.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if borrowing is overdue.
     */
    public function isOverdue(): bool
    {
        return $this->status === 'borrowed' && $this->return_date->isPast();
    }

    /**
     * Get overdue days.
     */
    public function getOverdueDaysAttribute(): int
    {
        if (!$this->isOverdue()) {
            return 0;
        }
        return $this->return_date->diffInDays(now());
    }

    /**
     * Get status badge.
     */
    public function getStatusBadgeAttribute(): string
    {
        switch ($this->status) {
            case 'pending':
                return '<span class="badge badge-secondary">Menunggu</span>';
            case 'borrowed':
                if ($this->isOverdue()) {
                    return '<span class="badge badge-danger">Terlambat</span>';
                }
                return '<span class="badge badge-warning">Dipinjam</span>';
            case 'returned':
                return '<span class="badge badge-success">Dikembalikan</span>';
            case 'lost':
                return '<span class="badge badge-dark">Hilang</span>';
            default:
                return '<span class="badge badge-info">' . ucfirst($this->status) . '</span>';
        }
    }

    /**
     * Scope for active borrowings.
     */
    public function scopeActive($query)
    {
        return $query->whereIn('status', ['pending', 'borrowed']);
    }

    /**
     * Scope for overdue borrowings.
     */
    public function scopeOverdue($query)
    {
        return $query->where('status', 'borrowed')
            ->where('return_date', '<', now()->toDateString());
    }

    /**
     * Scope for returned borrowings.
     */
    public function scopeReturned($query)
    {
        return $query->where('status', 'returned');
    }
}


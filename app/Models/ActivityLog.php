<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'activity', 'ip_address', 'user_agent'];

    /**
     * Get the user that owns the activity log.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Log an activity.
     */
    public static function log(string $activity, ?int $userId = null): self
    {
        return static::create([
            'user_id' => $userId ?? auth()->id(),
            'activity' => $activity,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}


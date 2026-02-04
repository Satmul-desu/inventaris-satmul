<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'is_active',
        'phone',
        'address',
        'photo',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the role that owns the user.
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Check if user is owner/admin.
     */
    public function isOwner(): bool
    {
        return $this->role && $this->role->name === 'owner';
    }

    /**
     * Check if user is staff.
     */
    public function isStaff(): bool
    {
        return $this->role && $this->role->name === 'staff';
    }

    /**
     * Check if user is active.
     */
    public function isActive(): bool
    {
        return $this->is_active;
    }

    /**
     * Get activity logs for this user.
     */
    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }

    /**
     * Get stock ins created by this user.
     */
    public function stockIns()
    {
        return $this->hasMany(StockIn::class);
    }

    /**
     * Get stock outs created by this user.
     */
    public function stockOuts()
    {
        return $this->hasMany(StockOut::class);
    }

    /**
     * Get stock logs created by this user.
     */
    public function stockLogs()
    {
        return $this->hasMany(StockLog::class);
    }

    /**
     * Get the profile photo URL.
     */
    public function getProfilePhotoUrlAttribute()
    {
        if ($this->photo) {
            return asset('storage/' . $this->photo);
        }
        return null;
    }

    /**
     * Get the default admin icon based on role.
     */
    public function getAdminIconAttribute()
    {
        if ($this->role) {
            switch ($this->role->name) {
                case 'owner':
                    return 'fa-user-shield';
                case 'admin':
                    return 'fa-user-cog';
                case 'staff':
                    return 'fa-user-edit';
                default:
                    return 'fa-user';
            }
        }
        return 'fa-user';
    }
}


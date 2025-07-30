<?php
// namespace App\Models;

// use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\Factories\HasFactory;

// class Secret extends Model
// {
//     protected $fillable = [
//         'text', 'slug', 'expires_at', 'used', 'user_id'
//     ];

//     protected $casts = [
//         'expires_at' => 'datetime',
//         'used' => 'boolean',
//     ];
// }



namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Secret extends Model
{
    use HasFactory;

    protected $fillable = [
        'text',
        'slug',
        'expires_at',
        'used',
        'viewed_at',
        'user_id',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'viewed_at' => 'datetime',
        'used' => 'boolean',
    ];

    protected $hidden = [
        'text', // Hide secret text by default for security
    ];

    /**
     * Get the user that owns the secret.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if the secret is expired.
     */
    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    /**
     * Check if the secret is still active (not used and not expired).
     */
    public function isActive(): bool
    {
        return !$this->used && !$this->isExpired();
    }

    /**
     * Get the status of the secret.
     */
    public function getStatusAttribute(): string
    {
        if ($this->used) {
            return 'used';
        }
        
        if ($this->isExpired()) {
            return 'expired';
        }
        
        return 'active';
    }

    /**
     * Scope for active secrets.
     */
    public function scopeActive($query)
    {
        return $query->where('used', false)
                    ->where(function($q) {
                        $q->whereNull('expires_at')
                          ->orWhere('expires_at', '>', now());
                    });
    }

    /**
     * Scope for expired secrets.
     */
    public function scopeExpired($query)
    {
        return $query->where('expires_at', '<=', now());
    }

    /**
     * Scope for used secrets.
     */
    public function scopeUsed($query)
    {
        return $query->where('used', true);
    }

    /**
     * Scope to get secrets by user.
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}
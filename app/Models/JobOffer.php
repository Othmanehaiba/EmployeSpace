<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobOffer extends Model
{
    protected $table = 'job_offers';

    protected $fillable = [
        'recruteur_user_id',
        'company_name',
        'contract_type',
        'title',
        'location',
        'start_date',
        'description',
        'image_path',
        'status',
        'closed_at',
    ];

    protected $casts = [
        'start_date' => 'date',
        'closed_at' => 'datetime',
    ];

    public const STATUS_OPEN = 'open';
    public const STATUS_CLOSED = 'closed';

    public const CONTRACT_TYPES = [
        'CDI' => 'CDI',
        'CDD' => 'CDD',
        'Stage' => 'Stage',
        'Freelance' => 'Freelance',
        'Full-time' => 'Full-time',
        'Part-time' => 'Part-time',
    ];

    public function recruteur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recruteur_user_id');
    }

    public function applications(): HasMany
    {
        return $this->hasMany(JobApplication::class);
    }

    public function isOpen(): bool
    {
        return $this->status === self::STATUS_OPEN;
    }

    public function close(): void
    {
        $this->update([
            'status' => self::STATUS_CLOSED,
            'closed_at' => now(),
        ]);
    }

    public function scopeOpen($query)
    {
        return $query->where('status', self::STATUS_OPEN);
    }

    public function scopeClosed($query)
    {
        return $query->where('status', self::STATUS_CLOSED);
    }
}

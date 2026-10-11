<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Claim extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id', 'claimant_name', 'ownership_description',
        'status', 'decision_reason', 'decided_by', 'decided_at',
    ];

    protected function casts(): array
    {
        return [
            'decided_at' => 'datetime',
        ];
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    public function isPending(): bool
    {
        return $this->status === 'menunggu';
    }

    /** Klaim lebih dari 24 jam menunggu ditandai Perlu ditinjau (AC-07.2). */
    public function needsReview(): bool
    {
        return $this->isPending() && $this->created_at->diffInHours(now()) >= 24;
    }

    public function waitingDuration(): string
    {
        $hours = (int) $this->created_at->diffInHours(now());

        return $hours < 24
            ? $hours . ' jam'
            : intdiv($hours, 24) . ' hari';
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'menunggu'         => 'Menunggu verifikasi',
            'disetujui'        => 'Menunggu pengambilan',
            'ditolak'          => 'Ditolak',
            'ditolak_otomatis' => 'Ditolak otomatis',
            default            => $this->status,
        };
    }

    public function getStatusToneAttribute(): string
    {
        return match ($this->status) {
            'disetujui'                    => 'approved',
            'ditolak', 'ditolak_otomatis'  => 'rejected',
            default                        => 'pending',
        };
    }
}

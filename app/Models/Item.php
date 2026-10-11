<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Item extends Model
{
    use HasFactory;

    /** Kategori yang barangnya wajib dititipkan ke posko fakultas (AC-03.3). */
    public const KATEGORI_POSKO = ['Dompet', 'Elektronik', 'Kunci'];

    public const KATEGORI = ['Dompet', 'Elektronik', 'Kunci', 'Lain-lain'];

    protected $fillable = [
        'name', 'category', 'location', 'faculty', 'found_at',
        'route', 'finder_contact', 'hidden_traits', 'status', 'expires_at',
    ];

    protected function casts(): array
    {
        return [
            'found_at'   => 'date',
            'expires_at' => 'date',
        ];
    }

    public function claims(): HasMany
    {
        return $this->hasMany(Claim::class);
    }

    /** Klaim yang masih menunggu keputusan petugas. */
    public function pendingClaims(): HasMany
    {
        return $this->hasMany(Claim::class)->where('status', 'menunggu');
    }

    /* ---------------------------------------------------------------
     | Aturan turunan kategori
     --------------------------------------------------------------- */

    /** Jalur penanganan ditentukan kategori, bukan diisi manual. */
    public static function routeForCategory(string $category): string
    {
        return in_array($category, self::KATEGORI_POSKO, true) ? 'posko' : 'penemu';
    }

    /** Masa tayang: 7 hari untuk Lain-lain, 30 hari untuk barang berharga. */
    public static function lifespanForCategory(string $category): int
    {
        return in_array($category, self::KATEGORI_POSKO, true) ? 30 : 7;
    }

    public function isPoskoRoute(): bool
    {
        return $this->route === 'posko';
    }

    /** Hanya barang jalur posko berstatus aktif yang dapat diklaim. */
    public function isClaimable(): bool
    {
        return $this->isPoskoRoute() && $this->status === 'aktif';
    }

    /* ---------------------------------------------------------------
     | Label untuk tampilan
     --------------------------------------------------------------- */

    public function getRouteLabelAttribute(): string
    {
        return $this->isPoskoRoute() ? 'Jalur posko' : 'Jalur penemu';
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'aktif'                 => 'Aktif',
            'menunggu_pengambilan'  => 'Menunggu pengambilan',
            'sudah_diserahkan'      => 'Sudah diserahkan',
            'arsip'                 => 'Arsip',
            default                 => $this->status,
        };
    }
}

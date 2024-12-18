<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Siswa extends Model
{
    use HasUuids, HasFactory;

    public function orangTua(): BelongsTo
    {
        return $this->belongsTo(User::class, 'ortu_id');
    }

    public function kelas(): BelongsToMany
    {
        return $this->belongsToMany(Kelas::class, 'siswa_kelas')
            ->using(SiswaKelas::class)
            ->withPivot('periode', 'isAktif')
            ->withTimestamps();
    }

    public function siswaKelas(): HasMany
    {
        return $this->hasMany(SiswaKelas::class);
    }

    public function kasMasuks(): HasMany
    {
        return $this->hasMany(KasMasuk::class);
    }

    public function tagihans(): HasMany
    {
        return $this->hasMany(Tagihan::class);
    }

    protected static function booted(): void
    {

        static::addGlobalScope('user', function (Builder $query) {
            if (auth()->check() && auth()->user()->isUser()) {
                $query->where('ortu_id', auth()->user()->id);
            } elseif (auth()->check() && auth()->user()->isAdminSekolah()) {
                $query->whereRelation('kelas.unit.sekolah.admins', 'user_id', '=', auth()->user()->id);
            }
        });
    }
}

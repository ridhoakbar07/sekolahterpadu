<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Unit extends Model
{
    use HasUuids, HasFactory;

    public function sekolah(): BelongsTo
    {
        return $this->belongsTo(Sekolah::class);
    }

    public function kelas(): HasMany
    {
        return $this->hasMany(Kelas::class);
    }

    public function tagihans(): HasMany
    {
        return $this->hasMany(Tagihan::class);
    }

    public function posTerimas(): HasMany
    {
        return $this->hasMany(PosTerima::class);
    }

    public function kasMasuks(): HasMany
    {
        return $this->hasMany(KasMasuk::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class PosTerima extends Model
{
    use HasUuids, HasFactory;

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function detailKasMasuks(): HasMany
    {
        return $this->hasMany(DetailKasMasuk::class);
    }

    protected static function booted(): void
    {
        static::addGlobalScope('unit', function (Builder $query) {
            if (auth()->check() && auth()->user()->isAdminSekolah()) {
                $query->whereRelation('unit.sekolah.admins', 'user_id', '=', auth()->user()->id);
            }
        });
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KasKeluar extends Model
{
    use HasUuids, HasFactory;

    protected static function booted(): void
    {
        static::addGlobalScope('user', function (Builder $query) {
            if (auth()->check() && auth()->user()->isAdminSekolah()) {
                $query->where('admin_id', auth()->user()->id);
            }
        });
    }
}

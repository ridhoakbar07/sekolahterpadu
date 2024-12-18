<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sekolah extends Model
{
    use HasUuids, HasFactory;

    protected $casts = [
        'admin_id' => 'array',
    ];

    public function yayasan(): BelongsTo
    {
        return $this->belongsTo(Yayasan::class);
    }

    public function admins(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'admin_sekolahs')
            ->using(AdminSekolah::class)
            ->withTimestamps();
    }

    public function units(): HasMany
    {
        return $this->hasMany(Unit::class);
    }

    protected static function booted(): void
    {
        static::addGlobalScope('user', function (Builder $query) {
            if (auth()->check() && auth()->user()->isAdminSekolah()) {
                $query->whereRelation('admins', 'user_id', '=', auth()->user()->id);
            }
        });
    }
}

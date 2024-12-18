<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tagihan extends Model
{
    use HasUuids, HasFactory;

    public function siswas(): BelongsTo
    {
        return $this->belongsTo(Siswa::class);
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function pos_terimas(): BelongsTo
    {
        return $this->belongsTo(PosTerima::class);
    }
}

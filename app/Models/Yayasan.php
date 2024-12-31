<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Yayasan extends Model
{
    use HasUuids, HasFactory;

    protected $fillable = ['nama', 'tanggal_pendirian', 'alamat', 'telp', 'email', 'visi_misi', 'no_status_hukum', 'ketua_yayasan'];

    public function sekolahs(): HasMany
    {
        return $this->hasMany(Sekolah::class);
    }

}

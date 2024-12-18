<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class AdminSekolah extends Pivot
{
    use HasUuids, HasFactory;

    protected $table = 'admin_sekolahs';
}

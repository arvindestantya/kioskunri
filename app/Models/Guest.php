<?php

namespace App\Models;

use App\Models\Faculty;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Guest extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'no_identitas',
        'no_handphone',
        'email',
        'jenis_pengunjung',
        'nama_fakultas',
        'jenis_layanan',
        'perihal',
        'faculty_id',
    ];
    public function faculty(): BelongsTo
    {
        return $this->belongsTo(Faculty::class);
    }
}
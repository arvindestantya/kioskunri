<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermohonanInformasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'faculty_id',
        'nama',
        'file_identitas',
        'alamat_ktp',
        'alamat_sekarang',
        'no_hp',
        'email',
        'informasi',
        'tujuan',
        'cara_memperoleh',
        'cara_mendapatkan',
        'tanggal',
    ];

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }
}

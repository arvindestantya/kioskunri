<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeberatanInformasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'faculty_id',
        'nama',
        'file_identitas',
        'alamat_sekarang',
        'telepon',
        'email',
        'informasi',
        'tujuan',
        'alasan',
    ];

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }
}

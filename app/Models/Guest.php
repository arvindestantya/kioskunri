<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
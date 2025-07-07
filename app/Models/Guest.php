<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'no_handphone',
        'email',
        'jenis_pengunjung',
        'perihal',
        'faculty_id', // <-- TAMBAHKAN BARIS INI
    ];
}
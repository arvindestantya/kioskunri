<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    /**
     * Properti yang bisa diisi secara massal (mass assignable).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'faculty_id',
        'title',
        'description',
        'start_date',
        'end_date',
    ];

    /**
     * Casting tipe data untuk atribut.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * Relasi ke model Faculty (Jadwal ini milik satu fakultas).
     */
    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }
}

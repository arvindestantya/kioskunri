<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // <-- TAMBAHKAN INI

class Flyer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'path',
        'faculty_id', // Pastikan ini ada di $fillable
    ];


    /**
     * INI ADALAH RELASI YANG HILANG
     * Mendefinisikan bahwa satu flyer dimiliki oleh satu fakultas.
     */
    public function faculty(): BelongsTo
    {
        return $this->belongsTo(Faculty::class);
    }
}
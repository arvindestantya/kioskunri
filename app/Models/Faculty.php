<?php

namespace App\Models;

use App\Models\Feedback;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany; // <-- Tambahkan ini jika belum ada

class Faculty extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];
    
    /**
     * INI ADALAH RELASI YANG HILANG
     * Mendefinisikan bahwa satu fakultas memiliki banyak flyer.
     */
    public function flyers(): HasMany
    {
        return $this->hasMany(Flyer::class);
    }
    
    /**
     * Mendefinisikan bahwa satu fakultas memiliki banyak tamu.
     */
    public function guests(): HasMany
    {
        return $this->hasMany(Guest::class);
    }
    
    /**
     * Mendefinisikan bahwa satu fakultas memiliki banyak tamu.
     */
    public function feedbacks(): HasMany
    {
        return $this->hasMany(Feedback::class);
    }

    /**
     * Mendefinisikan bahwa satu fakultas memiliki banyak user (admin).
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
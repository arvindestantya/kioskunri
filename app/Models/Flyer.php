<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Flyer extends Model
{
    use HasFactory;

    protected $fillable = [
        'path',
        'faculty_id',
    ];
    
    public function faculty(): BelongsTo
    {
        return $this->belongsTo(Faculty::class);
    }
}
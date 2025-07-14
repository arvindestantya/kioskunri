<?php

namespace App\Models;

use App\Models\Faculty;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Map extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'path',
        'faculty_id',
    ];

    public function faculty(): BelongsTo
    {
        return $this->belongsTo(Faculty::class);
    }
}

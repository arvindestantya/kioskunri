<?php

namespace App\Models;

use App\Models\Faculty;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Feedback extends Model
{
    use HasFactory;
    protected $table = 'feedbacks';

    protected $fillable = [
        'nama',
        'kritik',
        'saran',
        'faculty_id',
    ];

    public function faculty(): BelongsTo
    {
        return $this->belongsTo(Faculty::class);
    }
    
}

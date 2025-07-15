<?php

namespace App\Models;

use App\Models\Map;
use App\Models\Event;
use App\Models\Contact;
use App\Models\Feedback;
use App\Models\Schedule;
use App\Models\Announcement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Faculty extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    public function flyers(): HasMany
    {
        return $this->hasMany(Flyer::class);
    }
    
    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }
    
    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }
    
    public function maps(): HasMany
    {
        return $this->hasMany(Map::class);
    }
    
    public function announcements(): HasMany
    {
        return $this->hasMany(Announcement::class);
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    public function guests(): HasMany
    {
        return $this->hasMany(Guest::class);
    }

    public function feedbacks(): HasMany
    {
        return $this->hasMany(Feedback::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
<?php

namespace App\Models;

use App\Models\User;
use App\Models\Artist;
use App\Models\Location;
use App\Models\Organizer;
use App\Models\Registration;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;

class Event extends Model
{    use InteractsWithMedia;

    protected $fillable = [
        'title',
        'description',
        'date',
        'location',
        'category',
        'organizer_id',
    ];

    protected $casts = [
        'date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function artists()
    {
        return $this->belongsToMany(Artist::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function organizer()
    {
        return $this->belongsTo(Organizer::class);
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('event_images')
             ->singleFile();
    }
}

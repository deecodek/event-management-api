<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\InteractsWithMedia;

class Event extends Model
{
    use InteractsWithMedia, LogsActivity;

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

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll() // Log all attributes
            ->logOnlyDirty() // Only log changes when attributes are modified
            ->setDescriptionForEvent(fn (string $eventName) => "Event {$eventName}"); // Custom description
    }
}

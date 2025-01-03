<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Artist extends Model
{
    use LogsActivity;

    protected $fillable = [
        'name',
        'bio',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function events()
    {
        return $this->belongsToMany(Event::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll() // Log all attributes
            ->logOnlyDirty() // Only log changes when attributes are modified
            ->setDescriptionForEvent(fn (string $eventName) => "Event {$eventName}"); // Custom description
    }
}

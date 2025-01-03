<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Registration extends Model
{
    use LogsActivity;

    protected $fillable = [
        'user_id',
        'event_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll() // Log all attributes
            ->logOnlyDirty() // Only log changes when attributes are modified
            ->setDescriptionForEvent(fn (string $eventName) => "Event {$eventName}"); // Custom description
    }
}

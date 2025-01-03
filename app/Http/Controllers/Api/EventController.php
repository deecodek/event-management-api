<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EventResource;
use App\Models\Event;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $events = QueryBuilder::for(Event::class)
            ->allowedFilters([
                'title',
                'category',
                'location',
                AllowedFilter::exact('date'),
            ])
            ->allowedIncludes(['artists', 'location', 'organizer', 'registrations'])
            ->allowedSorts('title', 'date', 'created_at')
            ->paginate();

        return EventResource::collection($events);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'date' => 'required|date',
            'location' => 'required|string',
            'category' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $event = Event::create([
            'organizer_id' => auth()->id(),
            ...$request->except('image'),
        ]);

        if ($request->hasFile('image')) {
            $event->addMediaFromRequest('image')->toMediaCollection('event_images');
        }
        $event->load('location', 'organizer', 'registrations');

        return new EventResource($event);
    }

    public function show(Event $event)
    {
        return new EventResource($event->load(['artists', 'location', 'organizer', 'registrations']));
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'title' => 'sometimes|string',
            'description' => 'sometimes|string',
            'date' => 'sometimes|date',
            'location' => 'sometimes|string',
            'category' => 'sometimes|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $event->update($request->except('image'));

        if ($request->hasFile('image')) {
            $event->clearMediaCollection('event_images');
            $event->addMediaFromRequest('image')->toMediaCollection('event_images');
        }

        return new EventResource($event);
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return response()->json(['message' => 'Event deleted successfully']);
    }

    public function downloadPdf(Event $event)
    {
        $pdf = Pdf::loadView('events.pdf', ['event' => $event]);

        return $pdf->download('event-details.pdf');
    }
}

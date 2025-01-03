<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrganizerResource;
use App\Models\Organizer;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class OrganizerController extends Controller
{
    public function index(Request $request)
    {
        $organizers = QueryBuilder::for(Organizer::class)
            ->allowedFilters([
                'name',
                'email',
                AllowedFilter::exact('id'),
            ])
            ->allowedIncludes(['events'])
            ->allowedSorts('name', 'email', 'created_at')
            ->paginate();

        return OrganizerResource::collection($organizers);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
        ]);

        $organizer = Organizer::create($request->all());

        return new OrganizerResource($organizer);
    }

    public function show(Organizer $organizer)
    {
        return new OrganizerResource($organizer->load('events'));
    }

    public function update(Request $request, Organizer $organizer)
    {
        $request->validate([
            'name' => 'sometimes|string',
            'email' => 'sometimes|email',
            'phone' => 'nullable|string',
        ]);

        $organizer->update($request->all());

        return new OrganizerResource($organizer);
    }

    public function destroy(Organizer $organizer)
    {
        $organizer->delete();

        return response()->json(['message' => 'Organizer deleted successfully']);
    }
}

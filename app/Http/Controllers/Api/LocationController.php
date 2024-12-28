<?php

namespace App\Http\Controllers\Api;

use App\Models\Location;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use App\Http\Resources\LocationResource;

class LocationController extends Controller
{
    public function index(Request $request)
    {
        $locations = QueryBuilder::for(Location::class)
            ->allowedFilters([
                'name',
                'city',
                'country',
                AllowedFilter::exact('id'),
            ])
            ->allowedIncludes(['events'])
            ->allowedSorts('name', 'city', 'created_at')
            ->paginate();

        return LocationResource::collection($locations);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'address' => 'required|string',
            'city' => 'required|string',
            'country' => 'required|string',
        ]);

        $location = Location::create($request->all());
        return new LocationResource($location);
    }

    public function show(Location $location)
    {
        return new LocationResource($location->load('events'));
    }

    public function update(Request $request, Location $location)
    {
        $request->validate([
            'name' => 'sometimes|string',
            'address' => 'sometimes|string',
            'city' => 'sometimes|string',
            'country' => 'sometimes|string',
        ]);

        $location->update($request->all());
        return new LocationResource($location);
    }

    public function destroy(Location $location)
    {
        $location->delete();
        return response()->json(['message' => 'Location deleted successfully']);
    }

}

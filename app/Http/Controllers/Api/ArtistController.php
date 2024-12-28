<?php

namespace App\Http\Controllers\Api;

use App\Models\Artist;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Resources\ArtistResource;
use Spatie\QueryBuilder\AllowedFilter;

class ArtistController extends Controller
{
    public function index(Request $request)
    {
        $artists = QueryBuilder::for(Artist::class)
            ->allowedFilters([
                'name',
                AllowedFilter::exact('id'),
            ])
            ->allowedIncludes(['events'])
            ->allowedSorts('name', 'created_at')
            ->paginate();

        return ArtistResource::collection($artists);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'bio' => 'nullable|string',
        ]);

        $artist = Artist::create($request->all());
        return new ArtistResource($artist);
    }

    public function show(Artist $artist)
    {
        return new ArtistResource($artist->load('events'));
    }

    public function update(Request $request, Artist $artist)
    {
        $request->validate([
            'name' => 'sometimes|string',
            'bio' => 'nullable|string',
        ]);

        $artist->update($request->all());
        return new ArtistResource($artist);
    }

    public function destroy(Artist $artist)
    {
        $artist->delete();
        return response()->json(['message' => 'Artist deleted successfully']);
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'date' => $this->date,
            'location' => $this->location,
            'category' => $this->category,
            'image_url' => $this->getFirstMediaUrl('event_images'),
            'artists' => ArtistResource::collection($this->whenLoaded('artists')),
            'organizer' => new OrganizerResource($this->whenLoaded('organizer')),
            'registrations' => RegistrationResource::collection($this->whenLoaded('registrations')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

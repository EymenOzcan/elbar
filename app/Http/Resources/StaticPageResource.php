<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StaticPageResource extends JsonResource
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
            'page_type' => $this->page_type,
            'title' => $this->title,
            'slug' => $this->slug,
            'image' => $this->image ? asset('storage/' . $this->image) : null,
            'banner_image' => $this->banner_image ? asset('storage/' . $this->banner_image) : null,
            'is_active' => $this->is_active,
            'translations' => StaticPageTranslationResource::collection($this->whenLoaded('translations')),
            'contact' => new StaticPageContactResource($this->whenLoaded('contact')),
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}

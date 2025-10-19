<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StaticPageTranslationResource extends JsonResource
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
            'language_id' => $this->language_id,
            'language_code' => $this->language->code ?? null,
            'language_name' => $this->language->name ?? null,
            'title' => $this->title,
            'content' => $this->content,
            'meta_description' => $this->meta_description,
            'custom_fields' => $this->custom_fields,
        ];
    }
}

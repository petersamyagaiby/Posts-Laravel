<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);

        return [
            "id" => $this->id,
            "title" => $this->title,
            "description" => $this->description,
            "image" => asset("images/" . $this->image),
            "user_id" => $this->user_id,
            "posted_by" => $this->user ? $this->user->name : null,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "deleted_at" => $this->deleted_at,
            "slug" => $this->slug,
        ];
    }
}

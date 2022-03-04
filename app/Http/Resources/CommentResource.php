<?php

namespace App\Http\Resources;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

/**
 * @property-read int                  $id
 * @property-read int                  $parent_id
 * @property-read string               $author
 * @property-read string               $body
 * @property-read Collection|Comment[] $children
 */
class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id'        => $this->id,
            'parent_id' => $this->parent_id,
            'author'    => $this->author,
            'body'      => $this->body,
            'children'  => CommentResource::collection($this->whenLoaded('children')),
        ];
    }
}

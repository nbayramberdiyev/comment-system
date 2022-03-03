<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request $request
     * @return array
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

<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CommentController extends Controller
{
    /**
     * Displays the comments of the specified post.
     *
     * @param  Request $request
     * @param  int     $post
     * @return ResourceCollection
     */
    public function index(Request $request, int $post): ResourceCollection
    {
        $comments = Comment::with('children.children')
            ->whereNull('parent_id')
            ->latest()
            ->paginate(10);

        return CommentResource::collection($comments);
    }

    /**
     * Creates a new comment for the specified post.
     *
     * @param  StoreCommentRequest $request
     * @param  int                 $post
     * @return CommentResource
     */
    public function store(StoreCommentRequest $request, int $post): CommentResource
    {
        $comment = Comment::create($request->validated());

        return new CommentResource($comment);
    }
}

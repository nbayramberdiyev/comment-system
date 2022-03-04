<?php

namespace Tests\Unit\Models;

use App\Models\Comment;
use PHPUnit\Framework\TestCase;

final class CommentTest extends TestCase
{
    /** @test */
    public function testCommentModelHasCorrectAttributes(): void
    {
        $attributes = [
            'parent_id' => 1,
            'author'    => 'Novruz',
            'body'      => 'This is a dummy comment',
        ];

        $comment = new Comment($attributes);

        $this->assertEquals($attributes, $comment->attributesToArray());
        $this->assertEquals($attributes['parent_id'], $comment->getAttribute('parent_id'));
        $this->assertEquals($attributes['author'], $comment->getAttribute('author'));
        $this->assertEquals($attributes['body'], $comment->getAttribute('body'));
    }

    /** @test */
    public function testRequiredAttributesAreFillable(): void
    {
        $comment = new Comment();

        $this->assertTrue($comment->isFillable('parent_id'));
        $this->assertTrue($comment->isFillable('author'));
        $this->assertTrue($comment->isFillable('body'));
    }
}

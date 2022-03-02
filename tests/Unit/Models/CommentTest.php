<?php

namespace Tests\Unit\Models;

use App\Models\Comment;
use PHPUnit\Framework\TestCase;

final class CommentTest extends TestCase
{
    /** @test */
    public function testCommentModelHasCorrectAttributes()
    {
        $attributes = [
            'author' => 'Novruz',
            'body'   => 'This is a dummy comment',
        ];

        $comment = new Comment($attributes);

        $this->assertEquals($attributes, $comment->attributesToArray());
        $this->assertEquals($attributes['author'], $comment->getAttribute('author'));
        $this->assertEquals($attributes['body'], $comment->getAttribute('body'));
    }

    /** @test */
    public function testAuthorAttributeIsFillable()
    {
        $comment = new Comment();

        $this->assertTrue($comment->isFillable('author'));
    }

    /** @test */
    public function testBodyAttributeIsFillable()
    {
        $comment = new Comment();

        $this->assertTrue($comment->isFillable('body'));
    }
}

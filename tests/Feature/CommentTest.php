<?php

namespace Tests\Feature;

use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use function route;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function testCommentsCanBeListed()
    {
        $comments = Comment::factory()->count(5)->create();

        $response = $this->getJson(route('posts.comments.index', 1));

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
                $json->hasAll(['data' => $comments->count(), 'meta', 'links'])
            )
            ->assertJsonStructure(['data' => [
                '*' => ['parent_id', 'author', 'body', 'children'],
            ]]);

        $this->assertDatabaseCount('comments', 5);
    }

    /** @test */
    public function testCommentCanBeCreatedWhenValidDataProvided()
    {
        $comment = [
            'author' => 'Novruz',
            'body'   => 'Lorem ipsum dolor sit amet.',
        ];

        $response = $this->postJson(route('posts.comments.store', 1), $comment);

        $response
            ->assertStatus(201)
            ->assertJsonPath('data.author', $comment['author'])
            ->assertJsonPath('data.body', $comment['body']);

        $this->assertDatabaseHas('comments', $comment);
    }

    /** @test */
    public function testCommentCanBeCreatedForParentWhenValidDataProvided()
    {
        $parent = Comment::factory()->create();
        $comment = [
            'parent_id' => $parent->id,
            'author'    => 'Novruz',
            'body'      => 'Lorem ipsum dolor sit amet.',
        ];

        $response = $this->postJson(route('posts.comments.store', 1), $comment);

        $response
            ->assertStatus(201)
            ->assertJsonPath('data.parent_id', $comment['parent_id'])
            ->assertJsonPath('data.author', $comment['author'])
            ->assertJsonPath('data.body', $comment['body']);

        $this->assertDatabaseHas('comments', $comment);
    }

    /** @test */
    public function testCommentCannotBeCreatedWhenAuthorIsInvalidOrEmpty()
    {
        $comment = [
            'author' => '',
            'body'   => 'Lorem ipsum dolor sit amet.',
        ];

        $response = $this->postJson(route('posts.comments.store', 1), $comment);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors(['author' => 'The author field is required.']);

        $this->assertDatabaseCount('comments', 0);
    }

    /** @test */
    public function testCommentCannotBeCreatedWhenBodyIsInvalidOrEmpty()
    {
        $comment = [
            'author' => 'Novruz',
            'body'   => '',
        ];

        $response = $this->postJson(route('posts.comments.store', 1), $comment);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrorFor('body');

        $this->assertDatabaseCount('comments', 0);
    }

    /** @test */
    public function testCommentCannotBeCreatedForParentWhenParentIdIsInvalidOrEmpty()
    {
        $comment = [
            'parent_id' => null,
            'author'    => 'Novruz',
            'body'      => 'Lorem ipsum dolor sit amet.',
        ];

        $response = $this->postJson(route('posts.comments.store', 1), $comment);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrorFor('parent_id');

        $this->assertDatabaseCount('comments', 0);
    }

    /** @test */
    public function testCommentCannotBeCreatedForParentWhenParentDoesntExist()
    {
        $comment = [
            'parent_id' => 1,
            'author'    => 'Novruz',
            'body'      => 'Lorem ipsum dolor sit amet.',
        ];

        $response = $this->postJson(route('posts.comments.store', 1), $comment);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrorFor('parent_id');

        $this->assertDatabaseCount('comments', 0);
    }
}

<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentTest extends TestCase
{
    public function testCreateComment()
    {
        $comment = new \App\Models\Comment();
        $comment->email = "rayhan@exc.com";
        $comment->title = "Sample Comment Title";
        $comment->comment = "This is a sample comment content.";
        $comment->save();

        self::assertNotNull($comment->id);
    }
}

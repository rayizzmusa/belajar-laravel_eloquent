<?php

namespace Tests\Feature;

use App\Models\Category;
use Database\Seeders\CategorySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use function PHPUnit\Framework\assertNotNull;

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

    public function testCreateCommentWithDefaultValues()
    {
        $comment = new \App\Models\Comment();
        $comment->email = "rayh@exc.com";
        //tidak mengisi title & comment, sehingga akan menggunakan default value dari model
        $comment->save();

        self::assertNotNull($comment->id);
        self::assertEquals("sample title default", $comment->title);
        self::assertEquals("sample comment default", $comment->comment);
    }

    //pembasahan fillable
    public function testCreateFillabe()
    {
        $request = [
            "id" => "FOOD",
            "name" => "Food",
            "description" => "Category for food stuff"
        ];
        $category = new Category($request);
        $category->save();

        assertNotNull($category->id);
        // jika ada eror mass assignment exception
        // maka ubah fillable di model Category.php
    }

    public function testCreateMethod()
    {
        $request = [
            "id" => "FASHION",
            "name" => "Fashion",
            "description" => "Category for fashion stuff"
        ];
        // $category = Category::query()->create($request); atau
        $category = Category::create($request);

        self::assertNotNull($category->id);
    }

    public function testUpdateMethod()
    {
        $this->seed(CategorySeeder::class);

        $request = [
            "name" => "Food Updated",
            "description" => "Food Category Updated"
        ];

        $category = Category::find("FOOD");
        $category->fill($request);
        $category->save();

        self::assertNotNull($category->id);
    }
}

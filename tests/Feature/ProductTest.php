<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Database\Seeders\CategorySeeder;
use Database\Seeders\CommentSeeder;
use Database\Seeders\ImageSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\TagSeeder;
use Database\Seeders\VoucherSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class ProductTest extends TestCase
{
    public function testOneToMany()
    {
        $this->seed(CategorySeeder::class);
        $this->seed(ProductSeeder::class);

        $product = Product::query()->find("1");
        self::assertNotNull($product);
        $category = $product->category;
        self::assertNotNull($category);
    }

    public function testOneToManyQuery()
    {
        $category = new Category();
        $category->id = 'DRINK';
        $category->name = "Aqua";
        $category->description = "Desc Aqua";
        $category->is_active = true;
        $category->save();
        self::assertNotNull($category);

        $product = new Product();
        $product->id = 1;
        $product->name = "Aqua Galon";
        $product->description = "Galon 10 liter";
        $category->products()->save($product);
        self::assertNotNull($product);
    }

    public function testRelationshipQuery()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);

        $category = Category::find("FOOD");
        $products = $category->products;
        $outOfStockProducts = $category->products()->where("stock", "<=", 0)->get();

        self::assertNotNull($products);
        self::assertNotNull($outOfStockProducts);
    }

    public function testOneToOnePolymorphic()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class, ImageSeeder::class]);

        $product = Product::find("1");
        self::assertNotNull($product);

        $image = $product->image;
        self::assertEquals("https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.smartsurvey.co.uk%2Fblog%2Fproduct-concept-what-is-it-how-to-use-it&psig=AOvVaw3eHRWLzmJy2R2hJ79HoaT6&ust=1763362692286000&source=images&cd=vfe&opi=89978449&ved=0CBcQjRxqFwoTCIDA3oiM9pADFQAAAAAdAAAAABAE", $image->url);
    }

    public function testOneToManyPolymorphic()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class, VoucherSeeder::class, CommentSeeder::class]);

        $product = Product::query()->first();
        $comments = $product->comments;
        self::assertCount(1, $comments);
        foreach ($comments as $comment) {
            self::assertEquals(Product::class, $comment->commentable_type);
            self::assertEquals($product->id, $comment->commentable_id);
        }
    }

    public function testHasOneOfManyPoly()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class, VoucherSeeder::class, CommentSeeder::class]);

        $product = Product::query()->first();
        $latest = $product->latestComment;
        self::assertNotNull($latest);

        $oldest = $product->oldestComment;
        self::assertNotNull($oldest);

        // $product->each(function ($item) {
        Log::info(json_encode($oldest));
        // });
    }

    public function testManyToManyPoly()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class, VoucherSeeder::class, TagSeeder::class]);

        $product = Product::find("1");
        $tags = $product->tags;
        self::assertCount(1, $tags);
    }
}

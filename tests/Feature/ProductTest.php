<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Database\Seeders\CategorySeeder;
use Database\Seeders\ProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
}

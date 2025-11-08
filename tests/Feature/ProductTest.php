<?php

namespace Tests\Feature;

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
}

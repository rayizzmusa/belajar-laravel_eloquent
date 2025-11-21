<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\Scopes\IsActiveScope;
use Database\Seeders\CategorySeeder;
use Database\Seeders\CustomerSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\ReviewSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertTrue;

class CategoryTest extends TestCase
{
    public function testInsert()
    {

        $category = new Category();
        $category->id = "GADGET";
        $category->name = "Gadget";
        $result = $category->save();

        assertTrue($result);
    }

    public function testInsertManyCategories()
    {
        $categories = [];
        for ($i = 0; $i < 10; $i++) {
            $categories[] = [
                "id" => "ID-$i",
                "name" => "Name $i",
                "is_active" => true
            ];
        }

        // $result = Category::query()->insert($categories); bisa gini
        $result = Category::insert($categories);

        assertTrue($result);

        $total = Category::query()->count();
        self::assertEquals(10, $total);
    }

    public function testFind()
    {
        $this->seed(CategorySeeder::class);

        // $category = Category::query()->find("FOOD"); atau
        $category = Category::find("FOOD");
        self::assertNotNull($category);
        self::assertEquals("FOOD", $category->id);
        self::assertEquals("Food", $category->name);
        self::assertEquals("Food Category", $category->description);
    }

    public function testUpdate()
    {
        $this->seed(CategorySeeder::class);

        $category = Category::find("FOOD");
        $category->name = "Food Update";

        // $result = $category->save(); bisa
        $result = $category->update();

        self::assertTrue($result);
    }

    public function testSelect()
    {
        for ($i = 0; $i < 10; $i++) {
            $category = new Category();
            $category->id = "ID-$i";
            $category->name = "category $i";
            $category->save();
        }

        $categories = Category::query()->whereNull("description")->get(); //ini select
        self::assertCount(10, $categories);
        $categories->each(function (Category $category) {
            self::assertNull($category->description); //collection disini bukan array, tapi object modelnya, jadi bisa dilakukan operasi lainnya
            $category->description = "updated";
            $category->save();
        });
    }

    public function testUpdateMany()
    {
        $categories = [];
        for ($i = 0; $i < 10; $i++) {
            $categories[] = [
                "id" => "ID-$i",
                "name" => "Name $i"
            ];
        }
        $result = Category::insert($categories);
        self::assertTrue($result);

        $result = Category::query()->whereNull("description")->update([
            "description" => "Updated desc"
        ]);

        $total = Category::query()->where("description", "Updated desc")->count();
        self::assertEquals(10, $total);
    }

    public function testDelete()
    {
        $this->seed(CategorySeeder::class);

        $category = Category::find("FOOD");
        $result = $category->delete();

        self::assertTrue($result);

        $category = Category::find("FOOD");
        self::assertNull($category);
    }

    public function testDeleteMany()
    {
        $categories = [];
        for ($i = 0; $i < 10; $i++) {
            $categories[] = [
                "id" => "ID-$i",
                "name" => "Name $i"
            ];
        }
        $result = Category::insert($categories);
        self::assertTrue($result);

        $result = Category::query()->where("id", "like", "ID-%")->delete();
        self::assertEquals(10, $result);

        $total = Category::query()->count();
        self::assertEquals(0, $total);
    }

    public function testGlobalScope()
    {
        $category = new Category();
        $category->id = "FOOD";
        $category->name = "Food";
        $category->description = "This Category GS";
        $category->is_active = false;
        $category->save();

        $categories = Category::find("FOOD");
        self::assertNull($categories);

        $category = Category::withoutGlobalScope(IsActiveScope::class)->find('FOOD');
        self::assertNotNull($category);
    }

    public function testQuerycategory()
    {
        $this->seed(CategorySeeder::class);
        $this->seed(ProductSeeder::class);

        $category = Category::query()->find('FOOD');
        self::assertNotNull($category);
        $products = $category->products;
        self::assertCount(1, $products);
    }

    public function testQueryProduct()
    {
        $this->seed(CategorySeeder::class);
        $this->seed(ProductSeeder::class);

        $product = Product::query()->find("1");
        self::assertNotNull($product);
        $category = $product->category;
        self::assertNotNull($category);
    }

    public function testHasOneOfMany()
    {
        $this->seed(CategorySeeder::class);
        $this->seed(ProductSeeder::class);

        $category = Category::query()->find('FOOD');

        $cheapProduct = $category->cheapestProduct;
        self::assertNotNull($cheapProduct);
        self::assertEquals("1", $cheapProduct->id);

        $mostExpensive = $category->mostExpensiveProduct;
        self::assertEquals("2", $mostExpensive->id);
    }

    public function testHasManyThrough()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class, CustomerSeeder::class, ReviewSeeder::class]);

        $category = Category::query()->find("FOOD");

        $reviews = $category->reviews;
        self::assertNotNull($reviews);
        self::assertCount(2, $reviews);
    }

    public function testQueryingRelations()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);

        $category = Category::find("FOOD");
        $products = $category->products()->where("price", "=", 300)->get();

        self::assertCount(1, $products);
        self::assertEquals("2", $products[0]->id);
    }

    public function testAggregatingRelations()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);

        $category = Category::find("FOOD");
        $total = $category->products()->count();

        self::assertEquals(2, $total);

        $products = $category->products()->where("price", 300)->count();
        self::assertEquals(1, $products);
    }
}

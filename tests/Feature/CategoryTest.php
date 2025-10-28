<?php

namespace Tests\Feature;

use App\Models\Category;
use Database\Seeders\CategorySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

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
                "name" => "Name $i"
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
}

<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $product = new Product();
        $product->id = "1";
        $product->name = "Prod 1";
        $product->description = "desc product 1";
        $product->category_id = "FOOD";
        $product->save();

        $product2 = new Product();
        $product2->id = "2";
        $product2->name = "Prod 2";
        $product2->description = "desc product 2";
        $product2->category_id = "FOOD";
        $product2->price = 300;
        $product2->save();
    }
}

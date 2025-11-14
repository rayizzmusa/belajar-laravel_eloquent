<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Wallet;
use Database\Seeders\CategorySeeder;
use Database\Seeders\CustomerSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\VirtualAccountSeeder;
use Database\Seeders\WalletSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    public function testOneToOne()
    {
        $this->seed([CustomerSeeder::class, WalletSeeder::class]);

        $customer = Customer::find("SYIFA");
        self::assertNotNull($customer);

        // $wallet = Wallet::where("customer_id", $customer_id)->first(); sudah tidak perlu gini, langsung saja memanggil atribute nya
        $wallet = $customer->wallet;
        self::assertNotNull($wallet);

        self::assertEquals(1000000, $wallet->amount);
    }

    //kebalikannya
    public function testOneToOne2()
    {
        $this->seed([CustomerSeeder::class, WalletSeeder::class]);

        $wallet = Wallet::where("customer_id", "SYIFA")->first();

        $customer = $wallet->customer;
        self::assertEquals("ray@exc.com", $customer->email);
    }

    public function testOneToOneQuery()
    {
        $customer = new Customer();
        $customer->id = "RAY";
        $customer->name = "Rayhan";
        $customer->email = "yan@exc.com";
        $customer->save();

        $wallet = new Wallet();
        $wallet->amount = 1000000;

        $customer->wallet()->save($wallet);

        self::assertNotNull($wallet->customer_id);
    }

    public function testHasOneThrough()
    {
        $this->seed([CustomerSeeder::class, WalletSeeder::class, VirtualAccountSeeder::class]);

        $customer = Customer::find("SYIFA");
        self::assertNotNull($customer);

        $virtualAccount = $customer->VirtualAccount;
        self::assertNotNull($virtualAccount);
        self::assertEquals("Mandiri", $virtualAccount->bank);
    }

    public function testManyToMany()
    {
        $this->seed([CustomerSeeder::class, CategorySeeder::class, ProductSeeder::class]);

        $customer = Customer::find("SYIFA");
        self::assertNotNull($customer);

        $customer->likeProducts()->attach("1"); //products id

        $products = $customer->likeProducts;
        self::assertCount(1, $products);
        self::assertEquals("1", $products[0]->id);
    }

    public function testManyToManyDetach()
    {
        $this->testManyToMany();

        $customer = Customer::query()->find("SYIFA");
        $customer->likeProducts()->detach("1");

        $products = $customer->likeProducts;

        self::assertNotNull($products);
        self::assertCount(0, $products);
    }

    public function testPivotAttribute()
    {
        $this->testManyToMany();

        $customer = Customer::query()->find("SYIFA");
        $products = $customer->likeProducts;

        foreach ($products as $product) {
            $pivot = $product->pivot;
            self::assertNotNull($pivot);
        }
    }
}

<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Wallet;
use Database\Seeders\CustomerSeeder;
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
}

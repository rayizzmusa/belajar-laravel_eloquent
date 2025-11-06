<?php

namespace Tests\Feature;

use App\Models\Customer;
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
}

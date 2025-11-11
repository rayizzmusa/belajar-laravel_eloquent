<?php

namespace Database\Seeders;

use App\Models\VirtualAccount;
use App\Models\Wallet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VirtualAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $wallet = Wallet::query()->where("customer_id", "SYIFA")->firstOrFail();

        $virtualAccount = new VirtualAccount();
        $virtualAccount->bank = "Mandiri";
        $virtualAccount->va_number = "1018062025";
        $virtualAccount->wallet_id = $wallet->id;
        $virtualAccount->save();
    }
}

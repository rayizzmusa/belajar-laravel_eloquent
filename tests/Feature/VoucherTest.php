<?php

namespace Tests\Feature;

use App\Models\Voucher;
use Database\Seeders\VoucherSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class VoucherTest extends TestCase
{
    public function testCreayeTableVoucher()
    {
        $voucher = new Voucher();
        $voucher->name = "Sample Vouceher";
        $voucher->voucher_code = "sample-voucher-001";
        $voucher->save();

        self::assertNotNull($voucher->id);
    }

    public function testCreateVoucherUuid()
    {
        $voucher = new Voucher();
        $voucher->name = "Sample Vouceher UUID";
        $voucher->save();

        self::assertNotNull($voucher->id);
        self::assertNotNull($voucher->voucher_code);
    }

    public function testSoftDelete()
    {
        $this->seed(VoucherSeeder::class);

        $voucher = Voucher::query()->where("voucher_code", "sample-voucher-001")->first();
        $voucher->delete();

        $voucher = Voucher::where("voucher_code", "sample-voucher-001")->first();
        self::assertNull($voucher);

        $voucher = Voucher::withTrashed()->where("voucher_code", "sample-voucher-001")->first();
        self::assertNotNull($voucher);
    }
}

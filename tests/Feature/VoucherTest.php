<?php

namespace Tests\Feature;

use App\Models\Voucher;
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
}

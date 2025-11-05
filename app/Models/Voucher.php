<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;

class Voucher extends Model
{
    use HasUlids, SoftDeletes;

    protected $table = "vouchers";
    protected $primaryKey = "id";
    protected $keyType = "string";
    public $incrementing = false;
    public $timestamps = false;

    public function uniqueIds()
    {
        return [$this->primaryKey, "voucher_code"];
    }

    //implementasi local scope
    public function scopeActive(Builder $builder)
    {
        $builder->where('is_active', true);
    }

    public function scopeNonActive(Builder $builder)
    {
        $builder->where('is_active', false);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Voucher extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'code', 'description', 'discount_type', 'discount_value',
        'max_discount', 'min_order_value', 'usage_limit', 'used_count',
        'valid_from', 'valid_to'
    ];
    public function role() {
        return $this->belongsTo(Role::class);
    }
}

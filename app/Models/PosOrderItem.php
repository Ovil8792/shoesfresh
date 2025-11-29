<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PosOrderItem extends Model
{
    use HasFactory;
    protected $table = 'pos_order_items';
    protected $fillable = ['pos_order_id', 'product_variant_id', 'quantity', 'price'];
    public function posOrder()
    {
        return $this->belongsTo(PosOrder::class, 'pos_order_id');
    }
    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class);
    }
    public function product()
    {
        return $this->hasOneThrough(Product::class, ProductVariant::class, 'id', 'id', 'product_variant_id', 'product_id');
    }
}

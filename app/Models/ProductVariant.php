<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductVariant extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['product_id', 'size_id', 'color_id', 'stock', 'price','sku'];

    public function product() {
        return $this->belongsTo(Product::class,  'product_id');
    }

    public function size() {
        return $this->belongsTo(Size::class);
    }

    public function color() {
        return $this->belongsTo(Color::class);
    }
    public function orderItems() {
        return $this->hasMany(OrderItem::class, 'product_variant_id');
    }
    public function posOrderItems() {
        return $this->hasMany(PosOrderItem::class, 'product_variant_id');
    }
}

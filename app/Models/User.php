<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Order;

class User extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'gender', 'birth_date', 'address',
        'points', 'tier', 'role_id', 'avatar'
    ];

    public function role() {
        return $this->belongsTo(Role::class,'role_id');
    }

    public function orders() {
        return $this->hasMany(Order::class, 'user_id');
    }

    /**
     * Kiểm tra xem user đã mua sản phẩm trong đơn hàng đã hoàn thành chưa
     * @param int $productId
     * @return bool
     */
    public function hasPurchasedProductInCompletedOrder($productId) {
        return Order::where('user_id', $this->id)
            ->where('status', Order::STATUS_COMPLETED)
            ->whereHas('orderItems.variant', function($query) use ($productId) {
                $query->where('product_id', $productId);
            })
            ->exists();
    }

}

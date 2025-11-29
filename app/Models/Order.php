<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory;
    use SoftDeletes;

    // ===== Trạng thái (đổi giá trị nếu DB bạn đang dùng khác) =====
    public const STATUS_PROCESSING = 'processing';   // = Đang xử lý
    public const STATUS_PENDING    = 'pending';
    public const STATUS_PAID       = 'paid';         // = Đã thanh toán
    public const STATUS_DELIVERING = 'delivering';
    public const STATUS_SHIPPING   = 'shipping';     // = Đang giao
    public const STATUS_COMPLETED  = 'completed';    // = Hoàn tất
    public const STATUS_CANCELLED  = 'cancelled';    // = Đã hủy

    public const STATUS_LABELS = [
        self::STATUS_PROCESSING => 'Đang xử lý',
        self::STATUS_PENDING    => 'Pending',
        self::STATUS_PAID       => 'Đã thanh toán',
        self::STATUS_SHIPPING   => 'Đang giao',
        self::STATUS_COMPLETED  => 'Hoàn tất',
        self::STATUS_CANCELLED  => 'Đã hủy',
    ];

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'total_amount',
        'voucher_id',
        'discount_applied',
        'status',
        'payment_method',
        'shipping_address'
    ];

    protected $appends = ['status_label'];

    // ===== Accessor: $order->status_label ra chữ tiếng Việt =====
    public function getStatusLabelAttribute(): string
    {
        return self::STATUS_LABELS[$this->status] ?? ucfirst((string) $this->status);
    }

    // ===== Scopes: dùng trong controller để lọc =====
    // Lọc theo trạng thái (bỏ qua khi 'all' hoặc null)
    public function scopeStatus($query, ?string $status)
    {
        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }
        return $query;
    }

    // Mặc định chỉ lấy đơn "đang xử lý"
    public function scopeDefaultProcessing($query)
    {
        return $query->where('status', self::STATUS_PROCESSING);
    }

    // Tạo option cho dropdown
    public static function statusOptions(bool $withAll = true): array
    {
        return $withAll
            ? ['all' => 'Tất cả trạng thái'] + self::STATUS_LABELS
            : self::STATUS_LABELS;
    }

    // ===== Quan hệ =====
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function delivery()
    {
        return $this->hasOne(Delivery::class, 'order_id');
    }
}

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
    public const STATUS_CONFIRMED  = 'confirmed';    // = Đã xác nhận
    public const STATUS_DELIVERING = 'delivering';   // = Đang giao
    public const STATUS_COMPLETED  = 'completed';    // = Hoàn tất
    public const STATUS_CANCELLED  = 'cancelled';    // = Đã hủy

    // Thứ tự các trạng thái (dùng để kiểm tra chuyển đổi hợp lệ)
    private const STATUS_ORDER = [
        self::STATUS_PROCESSING => 1,
        self::STATUS_CONFIRMED  => 2,
        self::STATUS_DELIVERING => 3,
        self::STATUS_COMPLETED  => 4,
        self::STATUS_CANCELLED  => 5,  // Once cancelled, cannot be changed back
    ];

    public const STATUS_LABELS = [
        self::STATUS_PROCESSING => 'Đang xử lý',
        self::STATUS_CONFIRMED  => 'Đã xác nhận',
        self::STATUS_DELIVERING => 'Đang giao',
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

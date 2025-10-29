<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hoadon extends Model
{
    protected $table = 'hoadons';
    protected $fillable = ['user_id', 'trangthaihoadon_id', 'phuongthucthanhtoan_id', 'diachi_id', 'sanpham_id', 'soluong', 'dongia', 'thanhtien'];
}

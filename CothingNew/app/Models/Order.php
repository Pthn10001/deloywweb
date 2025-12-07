<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // Bảng & khóa chính
    protected $table = 'tbl_order';
    protected $primaryKey = 'order_id';

    // Không dùng timestamps tự động của Laravel
    public $timestamps = false;

    // Cho phép fill các trường này (thêm order_code nếu bạn có cột này)
    protected $fillable = [
        'shipping_id',
        'customer_id',
        'order_status',
        'order_code',
        'order_total',
        'created_at',
    ];

    // Giá trị mặc định cho order_status
    protected $attributes = [
        'order_status' => 0,
    ];

    // QUAN TRỌNG: để created_at trả về đối tượng Carbon (format được ở view)
    protected $casts = [
        'created_at' => 'datetime',
    ];
}

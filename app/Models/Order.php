<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'order_number', 'status',
        'subtotal', 'shipping', 'total',
        'shipping_name', 'shipping_phone', 'shipping_address',
        'shipping_city', 'shipping_zip', 'notes', 'payment_method',
    ];

    const STATUSES = ['pending', 'confirmed', 'shipped', 'delivered', 'cancelled'];

    const STATUS_COLORS = [
        'pending'   => 'warning',
        'confirmed' => 'info',
        'shipped'   => 'primary',
        'delivered' => 'success',
        'cancelled' => 'danger',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getStatusColorAttribute(): string
    {
        return self::STATUS_COLORS[$this->status] ?? 'secondary';
    }

    public static function generateOrderNumber(): string
    {
        return 'RW-' . strtoupper(uniqid());
    }
}

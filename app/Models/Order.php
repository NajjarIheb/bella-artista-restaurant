<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'customer_name',
        'phone',
        'address',
        'total_price',
        'delivery_fee',
        'status',
        'payment_method',
        'payment_status',
        'flouci_payment_id',
        'order_type',
        'delivery_zone_id',
        'delivered_at',
        'cancellation_reason',
        'notes'
    ];

    protected $casts = [
        'delivered_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function deliveryZone()
    {
        return $this->belongsTo(DeliveryZone::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}

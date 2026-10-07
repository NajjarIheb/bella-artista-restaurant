<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'user_id',
        'phone',
        'type',
        'read_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }
}

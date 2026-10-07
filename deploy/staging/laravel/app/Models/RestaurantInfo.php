<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'hours',
        'address',
        'phone',
        'social_links',
        'delivery_radius',
        'min_order_amount',
        'delivery_fee',
        'logo_url',
        'about',
        'rating',
        'plus_code',
        'cover_url',
        'maps_url',
        'place_id',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'social_links' => 'array',
        'rating' => 'float',
    ];
}

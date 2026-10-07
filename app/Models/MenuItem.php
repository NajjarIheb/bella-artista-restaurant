<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'category_id',
        'category_name',
        'image_url',
        'is_available',
        'cost_price',
        'is_deal',
        'deal_group',
        'allergens'
    ];

    protected $casts = [
        'is_available' => 'boolean',
        'is_deal' => 'boolean',
        'price' => 'decimal:2',
        'cost_price' => 'decimal:2',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

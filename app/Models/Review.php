<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'rating',
        'comment',
        'date',
        'approved'
    ];

    protected $casts = [
        'approved' => 'boolean',
        'date' => 'date',
    ];
}

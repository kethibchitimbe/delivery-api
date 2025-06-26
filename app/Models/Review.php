<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'user_id',
        'restaurant_id',
        'rating',
        'comment',
    ];

    public function order()
    {
        return $this->belongsTo(\App\Models\Order::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function restaurant()
    {
        return $this->belongsTo(\App\Models\Restaurant::class);
    }
}

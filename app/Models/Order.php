<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'restaurant_id',
        'total_price',
        'status',
        'payment_status',
        'delivery_address',
        'placed_at',
        'completed_at',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
    public function restaurant()
    {
        return $this->belongsTo(\App\Models\Restaurant::class);
    }
    public function orderItems()
    {
        return $this->hasMany(\App\Models\OrderItem::class);
    }
    public function delivery()
    {
        return $this->hasOne(\App\Models\Delivery::class);
    }
    public function review()
    {
        return $this->hasOne(\App\Models\Review::class);
    }
}

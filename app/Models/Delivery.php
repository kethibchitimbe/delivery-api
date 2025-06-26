<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'delivery_partner_id',
        'status',
        'delivered_at',
    ];

    public function order()
    {
        return $this->belongsTo(\App\Models\Order::class);
    }

    public function deliveryPartner()
    {
        return $this->belongsTo(\App\Models\User::class, 'delivery_partner_id');
    }
}

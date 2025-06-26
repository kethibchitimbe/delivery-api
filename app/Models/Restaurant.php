<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'address',
        'phone',
        'description',
        'logo_url',
        'is_active',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
    public function menus()
    {
        return $this->hasMany(\App\Models\Menu::class);
    }
    public function orders()
    {
        return $this->hasMany(\App\Models\Order::class);
    }
    public function reviews()
    {
        return $this->hasMany(\App\Models\Review::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_Room extends Model
{
    use HasFactory;
    protected $table = "order_rooms";
    protected $fillable = [
        'order_id',
        'adult_id',
        'child_id',
        'room_id',
        'price_id',
        'type'
    ];

    public function adult()
    {
        return $this->hasOne(Order_Adult::class, 'id', 'adult_id');
    }

    public function child()
    {
        return $this->hasOne(Order_Child::class, 'id', 'child_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_Child_Bed extends Model
{
    use HasFactory;
    protected $table = "order_child_beds";
    protected $fillable = [
        'order_id',
        'order_child_id'
    ];
}

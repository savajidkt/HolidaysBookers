<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_Adult extends Model
{
    use HasFactory;
    protected $table = "order_adult";
    protected $fillable = [
        'order_id',
        'first_name',
        'last_name',
        'id_proof_type',
        'id_proof_no'
    ];
}

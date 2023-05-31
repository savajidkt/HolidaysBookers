<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_Form extends Model
{
    use HasFactory;
    protected $table = "order_form_datas";
    protected $fillable = [
        'order_id',
        'form_data_serialize'
    ];  
}

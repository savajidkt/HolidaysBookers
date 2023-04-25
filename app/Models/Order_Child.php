<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_Child extends Model
{
    use HasFactory;
    protected $table = "order_childs";
    protected $fillable = [
        'order_id',
        'child_first_name',
        'child_last_name',
        'child_id_proof_type',
        'child_id_proof_no',
        'child_age',
    ];

    public function childBed()
    {
        return $this->hasMany(Order_Child_Bed::class, 'order_child_id', 'id');
    }
}

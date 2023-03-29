<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class PackageInclusion extends Pivot
{
    use HasApiTokens, HasFactory, SoftDeletes, Notifiable;
    protected $table = 'package_inclusions';
    protected $fillable = [
        'package_id',
        'inclusion_name'
    ];
}

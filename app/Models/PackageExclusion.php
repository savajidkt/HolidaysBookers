<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class PackageExclusion extends Pivot
{
    use HasApiTokens, HasFactory, SoftDeletes, Notifiable;
    protected $table = 'package_exclusions';
    protected $fillable = [
        'package_id',
        'exclusion_name'
    ];
}

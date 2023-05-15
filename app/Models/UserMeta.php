<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class UserMeta extends Authenticatable
{
    use HasApiTokens, HasFactory, SoftDeletes, Notifiable;
    protected $table = 'user_metas';
    protected $fillable = [
        'user_id',
        'country_id',
        'user_avatar',
        'phone_number',
        'address_1',
        'address_2',
        'city',
        'state',
        'zip'
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Agent extends Authenticatable
{
    use HasFactory;
    protected $guard = 'agent';
    protected $table = 'users';
    protected $fillable = [
        'first_name',
        'last_name',
        'user_type',
        'status',
        'email',
        'password',
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
}

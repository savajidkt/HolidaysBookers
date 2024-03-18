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

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, SoftDeletes, Notifiable;

    const ACTIVE = 1;
    const INACTIVE = 0;

    /** User types */
    const AGENT = 1;
    const CUSTOMER  = 2;
    const VENDOR  = 3;
    const CORPORATE  = 4;

    const STATUS = [
        self::ACTIVE => 'Active',
        self::INACTIVE => 'Inactive'
    ];

    protected $with = ['agents'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
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

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function scopeStatus($query, $status)
    {
        $status = strtolower($status) == 'active' ? 1 : 0;
        return $query->where('status', $status);
    }

    /**
     * Method getActionAttribute
     *
     * @return string
     */
    public function getActionAttribute(): string
    {   
        
        $viewAction =  '<a href="' . route('customers.show', $this->id) . '" class="edit btn btn-info btn-sm" data-toggle="tooltip" data-original-title="View" data-animation="false"><i class="fa fa-eye" aria-hidden="true"></i></a>';        
        $editAction = '<a href="' . route('customers.edit', $this->customers->id) . '" class="edit btn btn-info btn-sm" data-toggle="tooltip" data-original-title="Edit" data-animation="false"><i class="fa fa-edit" aria-hidden="true"></i></a>'; 
        return $viewAction . ' ' . $editAction . ' ' . $this->getDeleteButtonAttribute();
    }

    /**
     * Get Delete Button Attribute
     *
     * @param string $class
     * @return string
     */
    public function getDeleteButtonAttribute($class = '')
    {
        return '<a href="' . route('customers.destroy', $this->customers->id) . '" class="delete_action btn btn-danger btn-sm" data-method="delete" data-toggle="tooltip" data-original-title="Delete" data-animation="false"><i class="fa fa-trash" aria-hidden="true"></i></a>';        
    }

    /**
     * Method getFullNameAttribute
     *
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }
    /**
     * Method getStatusAttribute
     *
     * @return string
     */
    public function getStatusNameAttribute(): string
    {
        $status = self::ACTIVE;

        switch ($this->status) {
            case self::INACTIVE:
                $status = '<a href="javascript:void(0)" class=""><span class="badge badge-danger status_update" data-user_id="' . $this->id . '" data-status="' . $this->status . '">' . self::STATUS[self::INACTIVE] . '</span></a>';
                break;
            default:
                $status = '<a href="javascript:void(0)" class=""><span class="badge badge-success status_update" data-user_id="' . $this->id . '" data-status="' . $this->status . '">' . self::STATUS[self::ACTIVE] . '</span></a>';
                break;
        }

        return $status;
    }

    /**
     * Method agent
     *
     * @return void
     */
    public function agents()
    {
        //return $this->belongsTo(Agent::class,'id','user_id');
        return $this->hasOne(Agent::class, 'user_id', 'id');
        //return $this->morphTo();
    }

       
    /**
     * Method customers
     *
     * @return void
     */
    public function customers()
    {
        return $this->hasOne(Customer::class, 'user_id', 'id');
    }

    public function usermeta()
    {
        return $this->hasOne(UserMeta::class, 'user_id', 'id');
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class, 'user_id', 'id');
    }
}

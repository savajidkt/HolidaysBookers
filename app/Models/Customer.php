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

class Customer extends Authenticatable
{
    use HasApiTokens, HasFactory, SoftDeletes, Notifiable;
    const ACTIVE = 1;
    const INACTIVE = 0;

    const STATUS = [
        self::ACTIVE => 'Active',
        self::INACTIVE => 'Inactive'
    ];


    protected $fillable = [
        'user_id',
        'dob',
        'country',
        'state',
        'city',
        'zipcode',
        'mobile_number'

    ];

    /**
     * Method getActionAttribute
     *
     * @return string
     */
    public function getActionAttribute(): string
    {        
        $viewAction =  '<a href="' . route('view-profile-customer', $this->id) . '" class="edit btn btn-info btn-sm" data-toggle="tooltip" data-original-title="View" data-animation="false"><i class="fa fa-eye" aria-hidden="true"></i></a>';        
        $editAction = '<a href="' . route('customers.edit', $this->id) . '" class="edit btn btn-info btn-sm" data-toggle="tooltip" data-original-title="Edit" data-animation="false"><i class="fa fa-edit" aria-hidden="true"></i></a>';                
        $PasswordAction = '<a href="javascript:void(0);" class="currntBTN btn btn-info btn-sm" data-user_id="' . $this->id . '" data-toggle="tooltip" data-original-title="Change Password"><i class="fa fa-key" aria-hidden="true"></i></a>';
        return $editAction . ' ' . $viewAction.' '.$PasswordAction. ' ' . $this->getDeleteButtonAttribute();
    }

    /**
     * Get Delete Button Attribute
     *
     * @param string $class
     * @return string
     */
    public function getDeleteButtonAttribute($class = '')
    {
        return '<a href="' . route('customers.destroy', $this) . '" class="delete_action btn btn-danger btn-sm" data-method="delete" data-toggle="tooltip" data-original-title="Delete" data-animation="false"><i class="fa fa-trash" aria-hidden="true"></i></a>';        
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
                $status = '<a href="javascript:void(0)" class=""><span class="badge badge-danger status_update" data-customer_id="' . $this->id . '" data-status="' . $this->status . '">' . __('core.inactive') . '</span></a>';
                break;
            default:
                $status = '<a href="javascript:void(0)" class=""><span class="badge badge-success status_update" data-customer_id="' . $this->id . '" data-status="' . $this->status . '">' . __('core.active') . '</span></a>';
                break;
        }
        return $status;
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function countryname()
    {
        return $this->belongsTo(Country::class, 'country', 'id');
    }
    public function statename()
    {
        return $this->belongsTo(State::class, 'state', 'id');
    }
    public function cityname()
    {
        return $this->belongsTo(City::class, 'city', 'id');
    }
}

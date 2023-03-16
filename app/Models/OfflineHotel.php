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

class OfflineHotel extends Authenticatable
{
    use HasApiTokens, HasFactory, SoftDeletes, Notifiable;

    const ACTIVE = 1;
    const INACTIVE = 0;

    /** Hotel types */
    const OFFLINE = 1;
    const API  = 2;

    const STATUS = [
        self::ACTIVE => 'Active',
        self::INACTIVE => 'Inactive'
    ];

    protected $table = "hotels";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'hotel_country',
        'hotel_state',
        'hotel_city',
        'hotel_group_id',
        'property_type_id',
        'hotel_type',
        'hotel_code',
        'hotel_name',
        'category',
        'phone_number',
        'fax_number',
        'hotel_address',
        'currency',
        'hotel_image_location',
        'hotel_description',
        'hotel_review',
        'hotel_email',
        'hotel_latitude',
        'hotel_longitude',
        'is_new',
        'cancel_days',
        'cancellation_policy',
        'status',

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
        
        $creditAction = '<a href="javascript:void(0);" class="HBCredit btn btn-success btn-sm" data-balance="' . availableBalance($this->id,'') . '" data-agent_code="' . $this->agent_code . '" data-user_id="' . $this->id . '" data-toggle="tooltip" data-original-title="HB Credit '.availableBalance($this->id).' " data-animation="false"><i class="fa fa-money" aria-hidden="true"></i></a>';
        $transactionAction ='<a href="' . route('list-hb-credit', $this->id) . '" class="edit btn btn-info btn-sm" data-toggle="tooltip" data-original-title="View Transaction" data-animation="false"><i class="fa fa-exchange" aria-hidden="true"></i></a>';
        $viewAction =  '<a href="' . route('view-profile', $this->id) . '" class="edit btn btn-info btn-sm" data-toggle="tooltip" data-original-title="View" data-animation="false"><i class="fa fa-eye" aria-hidden="true"></i></a>';        
        $editAction = '<a href="' . route('offlinehotels.edit', $this->id) . '" class="edit btn btn-info btn-sm" data-toggle="tooltip" data-original-title="Edit" data-animation="false"><i class="fa fa-edit" aria-hidden="true"></i></a>';        
        $PasswordAction = '<a href="javascript:void(0);" class="currntBTN btn btn-info btn-sm" data-user_id="' . $this->id . '" data-toggle="tooltip" data-original-title="Change Password"><i class="fa fa-key" aria-hidden="true"></i></a>';
        return $creditAction.' '.$editAction . ' ' . $PasswordAction . ' ' . $this->getDeleteButtonAttribute().' '.$transactionAction.' '.$viewAction;
    }

    /**
     * Get Delete Button Attribute
     *
     * @param string $class
     * @return string
     */
    public function getDeleteButtonAttribute($class = '')
    {
        return '<a href="' . route('offlinehotels.destroy', $this) . '" class="delete_action btn btn-danger btn-sm" data-method="delete" data-toggle="tooltip" data-original-title="Delete" data-animation="false"><i class="fa fa-trash" aria-hidden="true"></i></a>';
    }

    
    public function country()
    {
        return $this->belongsTo(Country::class, 'agent_country', 'id');
    }
    public function state()
    {
        return $this->belongsTo(State::class, 'agent_state', 'id');
    }
    public function city()
    {
        return $this->belongsTo(City::class, 'agent_city', 'id');
    }
    
    public function rooms()
    {
        return $this->belongsTo(Room::class, 'hotel_id', 'id');
    }
    public function reachus()
    {
        return $this->belongsTo(Reach::class, 'agent_know_about', 'id');
    }
    public function wallettransactions()
    {
        return $this->hasMany(WalletTransaction::class, 'agent_id', 'id');
    }
    public function getbalance()
    {
        return $this->hasOne(WalletTransaction::class,'agent_id', 'id')->orderBy('id','DESC');
    }
    public function images()
    {
        return $this->hasMany(HotelImage::class,'hotel_id', 'id');
    }
}

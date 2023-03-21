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
        'hotel_pincode',
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
        
        $viewAction =  '<a href="#" class="edit btn btn-info btn-sm" data-toggle="tooltip" data-original-title="View" data-animation="false"><i class="fa fa-eye" aria-hidden="true"></i></a>';
        $editAction = '<a href="' . route('offlinehotels.edit', $this->id) . '" class="edit btn btn-info btn-sm" data-toggle="tooltip" data-original-title="Edit" data-animation="false"><i class="fa fa-edit" aria-hidden="true"></i></a>';
        $addRoomAction = '<a href="'.route('room-create', $this->id).'" class="edit btn btn-success btn-sm" data-toggle="tooltip" data-original-title="Add Room" data-animation="false"><i class="fa fa-plus" aria-hidden="true"></i></a>';
        return $editAction . ' ' . $viewAction . ' '.$addRoomAction.' ' . $this->getDeleteButtonAttribute();
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
        return $this->belongsTo(Country::class, 'hotel_country', 'id');
    }
    public function state()
    {
        return $this->belongsTo(State::class, 'hotel_state', 'id');
    }
    public function city()
    {
        return $this->belongsTo(City::class, 'hotel_city', 'id');
    }
    
    public function rooms()
    {
        return $this->belongsTo(OfflineRoom::class, 'hotel_id', 'id');
    }
   
    public function images()
    {
        return $this->hasMany(HotelImage::class,'hotel_id', 'id');
    }
    public function amenity()
    {
        return $this->belongsTo(Amenity::class, 'amenities_id', 'id');
    }

    public function hotelamenity()
    {
        return $this->belongsToMany(Amenity::class, 'hotel_amenities', 'hotel_id', 'amenities_id');
    }
}

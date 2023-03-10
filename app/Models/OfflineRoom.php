<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use App\Models\OfflineRoomGallery;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class OfflineRoom extends Authenticatable
{
    use HasApiTokens, HasFactory, SoftDeletes, Notifiable;
    const ACTIVE = 1;
    const INACTIVE = 0;

    const OFFLINE = 1;
    const API = 2;

    const STATUS = [
        self::ACTIVE => 'Active',
        self::INACTIVE => 'Inactive'
    ];

    const TYPE = [
        self::OFFLINE => 'Offline',
        self::API => 'API'
    ];


    protected $fillable = [
        'hotel_id',
        'room_type_id',
        'amenities_id',
        'total_adult',
        'total_cwb',
        'total_cnb',
        'max_pax',
        'min_pax',
        'room_inclusion',
        'allotment',
        'cancel_policy',
        'accommodation_policy',
        'type',
        'api_name',
        'status'

    ];

    /**
     * Method getActionAttribute
     *
     * @return string
     */
    public function getActionAttribute(): string
    {
        $viewAction =  '<a href="' . route('view-room', $this->id) . '" class="edit btn btn-info btn-sm" data-toggle="tooltip" data-original-title="View" data-animation="false"><i class="fa fa-eye" aria-hidden="true"></i></a>';
        $editAction = '<a href="' . route('offlinerooms.edit', $this->id) . '" class="edit btn btn-info btn-sm" data-toggle="tooltip" data-original-title="Edit" data-animation="false"><i class="fa fa-edit" aria-hidden="true"></i></a>';
        $priceListAction ='<a href="' . route('list-hb-credit', $this->id) . '" class="edit btn btn-info btn-sm" data-toggle="tooltip" data-original-title="View Transaction" data-animation="false"><i class="fa fa-exchange" aria-hidden="true"></i></a>';
        return $editAction . ' ' . $viewAction . ' ' . $priceListAction . ' ' . $this->getDeleteButtonAttribute();
    }

    /**
     * Get Delete Button Attribute
     *
     * @param string $class
     * @return string
     */
    public function getDeleteButtonAttribute($class = '')
    {
        return '<a href="' . route('offlinerooms.destroy', $this) . '" class="delete_action btn btn-danger btn-sm" data-method="delete" data-toggle="tooltip" data-original-title="Delete" data-animation="false"><i class="fa fa-trash" aria-hidden="true"></i></a>';
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
                $status = '<a href="javascript:void(0)" class=""><span class="badge badge-danger status_update" data-offline_room_id="' . $this->id . '" data-status="' . $this->status . '">' . __('core.inactive') . '</span></a>';
                break;
            default:
                $status = '<a href="javascript:void(0)" class=""><span class="badge badge-success status_update" data-offline_room_id="' . $this->id . '" data-status="' . $this->status . '">' . __('core.active') . '</span></a>';
                break;
        }
        return $status;
    }


    public function getTypeNameAttribute(): string
    {
        $status = self::OFFLINE;
        switch ($this->status) {
            case self::API:
                $status = '<a href="javascript:void(0)" class=""><span class="badge badge-danger status_update" data-offline_room_id="' . $this->id . '" data-status="' . $this->status . '">' . __('core.inactive') . '</span></a>';
                break;
            default:
                $status = '<a href="javascript:void(0)" class=""><span class="badge badge-success status_update" data-offline_room_id="' . $this->id . '" data-status="' . $this->status . '">' . __('core.active') . '</span></a>';
                break;
        }
        return $status;
    }


    public function gallery()
    {
        return $this->hasMany(OfflineRoomGallery::class, 'room_id', 'id');
    }

    public function price()
    {
        return $this->belongsTo(OfflineRoomPrice::class, 'room_id', 'id');
    }
    public function childprice()
    {
        return $this->hasMany(OfflineRoomChildPrice::class, 'room_id', 'id');
    }

    public function hotel()
    {
        return $this->belongsTo(OfflineHotel::class, 'hotel_id', 'id');
    }
    public function roomtype()
    {
        return $this->belongsTo(RoomType::class, 'room_type_id', 'id');
    }
}

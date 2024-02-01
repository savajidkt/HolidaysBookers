<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelFacility extends Model
{
    use HasFactory;

    protected $table = "hotel_facility";

    const ACTIVE = 1;
    const INACTIVE = 0;

    const STATUS = [
        self::ACTIVE => 'Active',
        self::INACTIVE => 'Inactive'
    ];


    const HOTEL = 1;
    const ROOM = 2;

    const TYPE = [
        self::HOTEL => 'Hotel',
        self::ROOM => 'Room'
    ];



    protected $fillable = [
        'name',
        'type',
        'icon',
        'status'
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
        $editAction = '<a href="' . route('hotelfacility.edit', $this->id) . '" class="edit btn btn-info btn-sm" data-toggle="tooltip" data-original-title="' . __('core.edit') . '" data-animation="false"><i class="fa fa-edit" aria-hidden="true"></i></a> ';
        $action = $editAction . $this->getDeleteButtonAttribute();
        return $action;
    }

    /**
     * Get Delete Button Attribute
     *
     * @param string $class
     * @return string
     */
    public function getDeleteButtonAttribute($class = '')
    {
        return '<a href="' . route('hotelfacility.destroy', $this) . '" class="delete_action btn btn-danger btn-sm" data-method="delete" data-toggle="tooltip" data-original-title="' . __('core.delete') . '" data-animation="false"><i class="fa fa-trash" aria-hidden="true"></i></a>';
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
                $status = '<a href="javascript:void(0)" class=""><span class="badge badge-danger status_update" data-facility_id="' . $this->id . '" data-status="' . $this->status . '">' . __('core.inactive') . '</span></a>';
                break;
            default:
                $status = '<a href="javascript:void(0)" class=""><span class="badge badge-success status_update" data-facility_id="' . $this->id . '" data-status="' . $this->status . '">' . __('core.active') . '</span></a>';
                break;
        }

        return $status;
    }

    /**
     * Method getTypeNameAttribute
     *
     * @return string
     */
    public function getTypeNameAttribute(): string
    {
        $type = self::HOTEL;

        switch ($this->type) {
            case self::ROOM:
                //$type = self::TYPE[self::ROOM];
                $type = 'ROOM';
                break;
            default:
                //$type = self::TYPE[self::HOTEL];
                $type = 'Hotel';
                break;
        }

        return $type;
    }

    public function facilities()
    {
        return $this->hasMany(HotelFacilities::class, 'facility_id', 'id');
    }
}

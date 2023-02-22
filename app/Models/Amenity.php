<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Amenity extends Model
{
    use HasFactory;
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
        'amenity_name',
        'type',
        'status'
    ];

    public function scopeStatus($query, $status)
    {
        $status = strtolower($status) =='active'? 1 : 0;
        return $query->where('status', $status); 
    }

    /**
     * Method getActionAttribute
     *
     * @return string
     */
    public function getActionAttribute(): string
    {
        $viewAction = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';
        $editAction = '<a href="' . route('amenities.edit', $this->id) . '" class="edit" data-toggle="tooltip" data-original-title="Edit" data-animation="false"><img src="' . asset("app-assets/images/icons/icons8-edit-64.png") . '" width="20"></a>';


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
        return '<a href="' . route('amenities.destroy', $this) . '" class="delete_action" data-method="delete" data-toggle="tooltip" data-original-title="Delete" data-animation="false"><img src="' . asset("app-assets/images/icons/icons8-remove-48.png") . '" width="30"></a>';
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
                $status = '<a href="javascript:void(0)" class=""><span class="badge badge-danger status_update" data-amenity_type_id="' . $this->id . '" data-status="' . $this->status . '">' . self::STATUS[self::INACTIVE] . '</span></a>';
                break;
            default:
                $status = '<a href="javascript:void(0)" class=""><span class="badge badge-success status_update" data-amenity_type_id="' . $this->id . '" data-status="' . $this->status . '">' . self::STATUS[self::ACTIVE] . '</span></a>';
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
                $type = self::TYPE[self::ROOM];
                break;
            default:
                $type = self::TYPE[self::HOTEL];
                break;
        }

        return $type;
    }
}
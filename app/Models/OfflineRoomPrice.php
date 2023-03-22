<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class OfflineRoomPrice extends Authenticatable
{
    use HasApiTokens, HasFactory, SoftDeletes, Notifiable;

    const NORMAL = 1;
    const BLACKOUTSALE = 2;
    const STOPSALE = 0;
    const PROMOTIONAL = 3;



    const PRICE_TYPE = [
        self::NORMAL => 'NORMAL',
        self::BLACKOUTSALE => 'BLACKOUTSALE',
        self::STOPSALE => 'STOPSALE',
        self::PROMOTIONAL => 'PROMOTIONAL',
    ];

    protected $fillable = [
        'room_id',
        'from_date',
        'to_date',
        'booking_start_date',
        'booking_end_date',
        'single_adult_price',
        'adult_price',
        'extra_bed_price',
        'price_type'
    ];

    /**
     * Method getActionAttribute
     *
     * @return string
     */
    public function getActionAttribute(): string
    {

        $editAction = '<a href="' . route('edit-room-price', $this->id) . '" class="edit btn btn-info btn-sm" data-toggle="tooltip" data-original-title="Edit" data-animation="false"><i class="fa fa-edit" aria-hidden="true"></i></a>';
        return $editAction . ' ' . $this->getDeleteButtonAttribute();
    }

    /**
     * Method getDeleteButtonAttribute
     *
     * @param $class $class [explicite description]
     *
     * @return void
     */
    public function getDeleteButtonAttribute($class = '')
    {
        return '<a href="' . route('delete-room-price', $this->id) . '" class="delete_action btn btn-danger hhhh btn-sm" data-method="delete" data-toggle="tooltip" data-original-title="Delete" data-animation="false"><i class="fa fa-trash" aria-hidden="true"></i></a>';
    }

    /**
     * Method getPriceTypeNameAttribute
     *
     * @return string
     */
    public function getPriceTypeNameAttribute(): string
    {

        $price_type = self::NORMAL;
        switch ($this->price_type) {
            case self::BLACKOUTSALE:
                $price_type = '<a href="javascript:void(0)" class=""><span class="badge badge-info " >Blackout Sale</span></a>';
                break;
            case self::STOPSALE:
                $price_type = '<a href="javascript:void(0)" class=""><span class="badge badge-danger " >Stop Sale</span></a>';
                break;
            case self::PROMOTIONAL:
                $price_type = '<a href="javascript:void(0)" class=""><span class="badge badge-info " >Promotional</span></a>';
                break;
            default:
                $price_type = '<a href="javascript:void(0)" class=""><span class="badge badge-success ">Normal</span></a>';
                break;
        }
        return $price_type;
    }

    /**
     * Method room
     *
     * @return void
     */
    public function room()
    {
        return $this->belongsTo(OfflineRoom::class, 'room_id', 'id');
    }
    public function childprice()
    {
        return $this->hasMany(OfflineRoomChildPrice::class, 'price_id', 'id');
    }
}

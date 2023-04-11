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
        'currency_id',
        'cutoff_price',
        'min_nights',
        'min_overall_nights',
        'price_p_n_single_adult',
        'price_p_n_twin_sharing',
        'price_p_n_extra_adult',
        'price_p_n_cwb',
        'price_p_n_cob',
        'price_p_n_ccob',
        'tax_p_n_single_adult',
        'tax_p_n_twin_sharing',
        'tax_p_n_extra_adult',
        'tax_p_n_cwb',
        'tax_p_n_cob',
        'tax_p_n_ccob',
        'market_price',
        'promo_code',
        'rate_offered',
        'commission',
        'days_monday',
        'days_tuesday',
        'days_wednesday',
        'days_thursday',
        'days_friday',
        'days_saturday',
        'days_sunday',
        'price_type'
    ];

    /**
     * Method getActionAttribute
     *
     * @return string
     */
    public function getActionAttribute(): string
    {

        $editAction = '<a href="' . route('edit-room-price', $this->id) . '" class="edit btn btn-info btn-sm" data-toggle="tooltip" data-original-title="Edit" data-animation="false"><i class="fa fa-edit" aria-hidden="true"></i></a> ';
        $viewAction =  '<a href="' . route('show-room-price', $this->id) . '" class="edit btn btn-info btn-sm" data-toggle="tooltip" data-original-title="View" data-animation="false"><i class="fa fa-eye" aria-hidden="true"></i></a> ';
        return $editAction . '' . $viewAction . ' ' . $this->getDeleteButtonAttribute();
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
    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id', 'id');
    }
}

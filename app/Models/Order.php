<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    const ACTIVE = 1;
    const INACTIVE = 0;
    const YES = 1;
    const NO = 0;


    const STATUS = [
        self::ACTIVE => 'Active',
        self::INACTIVE => 'Inactive'
    ];

    const PAYMENT = [
        self::YES => 'Yes',
        self::NO => 'No'
    ];



    //protected $table = "reachus";
    protected $fillable = [
        'package_id',
        'hotel_id',
        'country_id',
        'city_id',
        'room_id',
        'confirmation_no',
        'booking_id',
        'voucher',
        'original_amount',
        'original_currency',
        'booking_amount',
        'booking_currency',
        'agent_code',
        'agent_email',
        'hotel_name',
        'check_in_date',
        'check_out_date',
        'cancelled_date',
        'type',
        'total_rooms',
        'total_nights',
        'rating',
        'adult_child_details',
        'child_age_details',
        'child_bad_details',
        'comments',
        'cancel_policy',
        'guest_lead',
        'guest_phone',
        'pax_info',
        'reference_id',
        'agent_markup_type',
        'agent_markup_val',
        'id_proof_type',
        'id_proof_no',
        'total_price_markup',
        'booked_by',
        'mail_sent',
        'payment',
        'status'
    ];

    /**
     * Method getActionAttribute
     *
     * @return string
     */
    public function getActionAttribute(): string
    {   $admin = auth()->user();
        $action ='';
        $viewAction = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">' . __('core.view') . '</a>';
        $editAction = '<a href="' . route('orders.edit', $this->id) . '" class="edit btn btn-info btn-sm" data-toggle="tooltip" data-original-title="' . __('core.edit') . '" data-animation="false"><i class="fa fa-edit" aria-hidden="true"></i></a> ';
        //if($admin->can('reach-us-view')){
            $action .= $viewAction;
       // }
       // if($admin->can('reach-us-edit')){
            $action .= $editAction;
       // } 

       // if($admin->can('reach-us-delete')){
             $action .= $this->getDeleteButtonAttribute();
        // }
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
        return '<a href="' . route('orders.destroy', $this) . '" class="delete_action btn btn-danger btn-sm" data-method="delete" data-toggle="tooltip" data-original-title="' . __('core.delete') . '" data-animation="false"><i class="fa fa-trash" aria-hidden="true"></i></a>';
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
                $status = '<a href="javascript:void(0)" class=""><span class="badge badge-danger status_update" data-reach_id="' . $this->id . '" data-status="' . $this->status . '">' . __('core.inactive') . '</span></a>';
                break;
            default:
                $status = '<a href="javascript:void(0)" class=""><span class="badge badge-success status_update" data-reach_id="' . $this->id . '" data-status="' . $this->status . '">' . __('core.active') . '</span></a>';
                break;
        }
        return $status;
    }

    public function getPaymentNameAttribute(): string
    {
        $payment = self::YES;
        switch ($this->payment) {
            case self::NO:
                $payment = '<a href="javascript:void(0)" class=""><span class="badge badge-danger " data-reach_id="' . $this->id . '" data-status="' . $this->payment . '">No</span></a>';
                break;
            default:
                $payment = '<a href="javascript:void(0)" class=""><span class="badge badge-success " data-reach_id="' . $this->id . '" data-status="' . $this->payment . '">Yes</span></a>';
                break;
        }
        return $payment;
    }

    public function getShowOtherTextboxNameAttribute(): string
    {

        if ($this->show_other_textbox == 0) {
            return '<span class="badge badge-danger" >' . __('core.no') . '</span>';
        } else {
            return '<span class="badge badge-success" >' . __('core.yes') . '</span>';
        }
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'hotel_id', 'id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }
}

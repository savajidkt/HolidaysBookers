<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DraftOrder extends Model
{
    protected $table = "draft_masters";
    use HasFactory, Notifiable;
 
    //protected $table = "reachus";
    protected $fillable = [       
        'original_amount',
        'original_currency',
        'booking_amount',
        'booking_currency',
        'tax',
        'tax_amount',
        'agent_markup_type',
        'agent_markup_val',
        'total_price_markup',
        'agent_code',
        'agent_email',
        'total_adult',
        'total_child',
        'total_child_with_bed',
        'total_child_without_bed',
        'total_rooms',
        'total_nights',       
        'comments',        
        'passenger_type',
        'lead_passenger_name',
        'lead_passenger_id_proof',
        'lead_passenger_id_proof_no',
        'lead_passenger_phone_code',
        'lead_passenger_phone',      
    ];

<<<<<<< HEAD
    /**
     * Method getActionAttribute
     *
     * @return string
     */
    public function getActionAttribute(): string
    {
        $admin = auth()->user();
        $action = '';
        $viewAction = '<a href="' . route('orders.show', $this->id) . '" class="edit btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></a> ';
        $editAction = '<a href="' . route('orders.edit', $this->id) . '" class="edit btn btn-info btn-sm" data-toggle="tooltip" data-original-title="' . __('core.edit') . '" data-animation="false"><i class="fa fa-edit" aria-hidden="true"></i></a> ';
        $paymentAction = '<a href="' . route('view-order-payment', $this->id) . '" class="btn btn-info btn-sm" data-toggle="tooltip" data-original-title="Payment Details" data-animation="false"><i class="fa fa-check-square-o" aria-hidden="true"></i></a> ';
        if ($this->mail_sent == 1) {
            $voucherAction = '<a target="_blank" href="' . url('storage/app/public/order/' . $this->id . '/vouchers/order-vouchers-' . $this->id . '.pdf') . '" class="btn btn-info btn-sm" data-toggle="tooltip" data-original-title="Voucher" data-animation="false"><i class="fa fa-file-o" aria-hidden="true"></i></a> ';
        } else {
            $voucherAction = '<a href="' . route('order-voucher-download', $this->id) . '" class="edit btn btn-info btn-sm" data-toggle="tooltip" data-original-title="Generate voucher & send mail" data-animation="false"><i class="fa fa-file-o" aria-hidden="true"></i></a> ';
        }

        //if($admin->can('reach-us-view')){
        $action .= $viewAction;
        // }
        //if($admin->can('reach-us-view')){
        $action .= $voucherAction;
        $action .= $paymentAction;
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
        $status = self::PROCESSED;
        switch ($this->status) {
            case self::CONFIRMED:
                $status = '<a href="javascript:void(0)" class=""><span class="badge badge-success " data-reach_id="' . $this->id . '" data-status="' . $this->status . '">Confirmed</span></a>';
                break;
            case self::CANCELLED:
                $status = '<a href="javascript:void(0)" class=""><span class="badge badge-danger " data-reach_id="' . $this->id . '" data-status="' . $this->status . '">Cancelled</span></a>';
                break;
            default:
                $status = '<a href="javascript:void(0)" class=""><span class="badge badge-info" data-reach_id="' . $this->id . '" data-status="' . $this->status . '">Processed</span></a>';
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

    public function getGuestNameAttribute(): string
    {
        switch ($this->passenger_type) {
            case 0:
                $passenger_type = $this->lead_passenger_name;
                break;
            default:
                $order_hotel_room = OrderHotelRoomPassenger::where('order_id', $this->id)->where('is_adult', 0)->first();
                $passenger_type = $order_hotel_room->name;
                break;
        }
        return $passenger_type;
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
        return $this->belongsTo(Country::class, 'hotel_country_id', 'id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'hotel_city_id', 'id');
    }

    public function hotel()
    {
        return $this->belongsTo(OfflineHotel::class, 'hotel_id', 'id');
    }

    public function adult()
    {
        return $this->hasMany(Order_Adult::class, 'order_id', 'id');
    }
    public function child()
    {
        return $this->hasMany(Order_Child::class, 'order_id', 'id');
    }

    public function agentcode()
    {
        return $this->belongsTo(Agent::class, 'agent_code', 'agent_code');
    }

    public function booking_payment()
    {
        return $this->belongsTo(Booking_payment_details::class, 'id', 'order_id');
    }

    public function formdata()
    {
        return $this->hasOne(Order_Form::class, 'order_id', 'id');
    }

    public function room()
    {
        return $this->hasMany(Order_Room::class, 'order_id', 'id')->orderBy('room_id', 'ASC');
    }

    public function order_hotel()
    {
        return $this->hasMany(OrderHotel::class, 'order_id', 'id');
    }
    public function order_rooms()
    {
        return $this->hasMany(OrderHotelRoom::class, 'order_id', 'id');
    }

    // public function childBed()
    // {
    //     return $this->hasMany(Order_Child_Bed::class, 'order_id', 'id');
    // }
=======
    public function draft_hotel()
    {
        return $this->hasMany(DraftOrderHotel::class, 'draft_id', 'id');
    }

    public function draft_hotel_rooms()
    {
        return $this->hasMany(DraftOrderHotelRoom::class, 'draft_id', 'id');
    }
>>>>>>> eaf5c587bdde40833701dc134f9d3daa0a00a061
}

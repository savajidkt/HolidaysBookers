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

class Agent extends Authenticatable
{
    use HasApiTokens, HasFactory, SoftDeletes, Notifiable;

    const ACTIVE = 1;
    const INACTIVE = 0;

    /** User types */
    const ADMIN = 1;
    const USER  = 2;

    const STATUS = [
        self::ACTIVE => 'Active',
        self::INACTIVE => 'Inactive'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'agent_code',
        'agent_company_name',
        'agent_company_type',
        'nature_of_business',
        'agent_first_name',
        'agent_last_name',
        'agent_designation',
        'agent_dob',
        'agent_office_address',
        'agent_country',
        'agent_state',
        'agent_city',
        'agent_pincode',
        'agent_telephone',
        'agent_mobile_number',
        'agent_email',
        'agent_website',
        'agent_iata',
        'agent_iata_number',
        'agent_other_certification',
        'agent_pan_number',
        'agent_gst_number',
        'mgmt_first_name',
        'mgmt_last_name',
        'mgmt_contact_number',
        'mgmt_email',
        'account_first_name',
        'account_last_name',
        'account_contact_number',
        'account_email',
        'reserve_first_name',
        'reserve_last_name',
        'reserve_contact_number',
        'reserve_email',
        'agent_pan_card',
        'agent_company_certificate',
        'agent_company_logo',
        'agent_know_about',
        'othername',

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function scopeStatus($query, $status)
    {
        $status = strtolower($status) == 'active' ? 1 : 0;
        return $query->where('user_status', $status);
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
        $editAction = '<a href="' . route('agents.edit', $this->id) . '" class="edit btn btn-info btn-sm" data-toggle="tooltip" data-original-title="Edit" data-animation="false"><i class="fa fa-edit" aria-hidden="true"></i></a>';        
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
        return '<a href="' . route('agents.destroy', $this) . '" class="delete_action btn btn-danger btn-sm" data-method="delete" data-toggle="tooltip" data-original-title="Delete" data-animation="false"><i class="fa fa-trash" aria-hidden="true"></i></a>';
    }

    /**
     * Method user
     *
     * @return void
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
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
    public function company()
    {
        return $this->belongsTo(CompanyType::class, 'agent_company_type', 'id');
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
        return $this->hasOne(WalletTransaction::class,'agent_id', 'id');
    }
}

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
        $status = strtolower($status) =='active'? 1 : 0;
        return $query->where('user_status', $status); 
    }

    /**
     * Method getActionAttribute
     *
     * @return string
     */
    public function getActionAttribute(): string
    {
        $viewAction = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';
        $editAction = '<a href="'. route('users.edit', $this->id).'" class="edit" data-toggle="tooltip" data-original-title="Edit" data-animation="false"><img src="'.asset("app-assets/images/icons/icons8-edit-64.png").'" width="20"></a>';
        
        $ResendAction ='';
        if( isset($this->survey->id) && in_array($this->survey->status, [UserSurvey::INPROGRESS, UserSurvey::PENDING]))
        {
            $ResendAction = '<a href="javascript:void(0)" class="resend" data-user_id="'.$this->id.'" data-toggle="tooltip" data-original-title="Survey Time Reset" data-animation="false"><img src="'.asset("app-assets/images/icons/icons8-available-updates-50.png").'" width="20"></a>';
        }
        
        $downloadAction = '';
        if( isset($this->survey->id) && $this->survey->status == UserSurvey::COMPLETED)
        {
            $downloadAction = '<a href="'. route('generate-pdf', $this->id).'" class="download " data-user_id="'.$this->id.'" data-toggle="tooltip" data-original-title="Download Survey" data-animation="false"><img src="'.asset("app-assets/images/icons/icons8-pdf-50.png").'" width="20"></a>';
            $downloadAction .= ' <a href="'. route('export', $this->id).'" class="download " data-user_id="'.$this->id.'" data-toggle="tooltip" data-original-title="Download Raw Data" data-animation="false"><img src="'.asset("app-assets/images/icons/icons8-microsoft-excel-50.png").'" width="20"></a>';
        }
        

        return $editAction.' '.$this->getDeleteButtonAttribute().' '.$ResendAction.' '.$downloadAction;
    }

    /**
     * Get Delete Button Attribute
     *
     * @param string $class
     * @return string
     */
    public function getDeleteButtonAttribute($class = '')
    {
        return '<a href="'.route('users.destroy', $this).'" class="delete_action" data-method="delete" data-toggle="tooltip" data-original-title="Delete" data-animation="false"><img src="'.asset("app-assets/images/icons/icons8-remove-48.png").'" width="30"></a>';
    }

    /**
     * Method getFullNameAttribute
     *
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        return $this->first_name.' '.$this->last_name;
    }
    /**
     * Method getStatusAttribute
     *
     * @return string
     */
    public function getStatusNameAttribute(): string
    {
        $status = self::ACTIVE;

        switch($this->user_status)
        {
            case self::INACTIVE:
                $status = '<a href="javascript:void(0)" class=""><span class="badge badge-danger status_update" data-user_id="'.$this->id.'" data-status="'.$this->user_status.'">'.self::STATUS[self::INACTIVE].'</span></a>';
                break;
            default:
                $status = '<a href="javascript:void(0)" class=""><span class="badge badge-success status_update" data-user_id="'.$this->id.'" data-status="'.$this->user_status.'">'.self::STATUS[self::ACTIVE].'</span></a>';
                break;
        }

        return $status;
    }
        
    /**
     * Method user
     *
     * @return void
     */
    public function user() 
    { 
        return $this->morphOne(User::class, 'agents');
    }

    public function country() 
    { 
        return $this->belongsTo(Country::class, 'country_id','id');
    }
    public function company() 
    { 
        return $this->belongsTo(CompanyType::class, 'agent_company_type','id');
    }
    public function reachus() 
    { 
        return $this->belongsTo(Reach::class, 'agent_know_about','id');
    }
}

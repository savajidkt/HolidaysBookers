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

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, SoftDeletes, Notifiable;

    const ACTIVE = 1;
    const INACTIVE = 0;

    /** User types */
    const AGENT = 1;
    const CUSTOMER  = 2;
    const VENDOR  = 3;
    const CORPORATE  = 4;

    const STATUS = [
        self::ACTIVE => 'Active',
        self::INACTIVE => 'Inactive'
    ];

    protected $with = ['agents'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'user_type',
        'status',
        'email',
        'password',
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

        switch($this->status)
        {
            case self::INACTIVE:
                $status = '<a href="javascript:void(0)" class=""><span class="badge badge-danger status_update" data-user_id="'.$this->id.'" data-status="'.$this->status.'">'.self::STATUS[self::INACTIVE].'</span></a>';
                break;
            default:
                $status = '<a href="javascript:void(0)" class=""><span class="badge badge-success status_update" data-user_id="'.$this->id.'" data-status="'.$this->status.'">'.self::STATUS[self::ACTIVE].'</span></a>';
                break;
        }

        return $status;
    }
     
    /**
     * Method agents
     *
     * @return void
     */
    public function agents()
    {
        return $this->belongsTo(Agent::class,'id','user_id');
      //return $this->morphTo();
    }
   

}

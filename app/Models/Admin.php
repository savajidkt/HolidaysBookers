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
use App\Permissions\HasPermissionsTrait;


class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, SoftDeletes, Notifiable;
    use HasPermissionsTrait; //Import The Trait

    const ACTIVE = 1;
    const INACTIVE = 0;

    /** User types */
    const SUPERADMIN = 1;
    const ADMIN  = 2;

    const STATUS = [
        self::ACTIVE => 'Active',
        self::INACTIVE => 'Inactive'
    ];

    const ROLE = [
        self::SUPERADMIN => 'Super Admin',
        self::ADMIN => 'Admin'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'admin';
    protected $fillable = [
        'name',
        'email',
        'password',
        'email',
        'role',
        'permissions',
        'status'
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
        $viewAction = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';
        $admin = auth()->user();
        $editAction = '<a href="' . route('admins.edit', $this->id) . '" class="edit" data-toggle="tooltip" data-original-title="Edit" data-animation="false"><img src="' . asset("app-assets/images/icons/icons8-edit-64.png") . '" width="20"></a>';
        
        

        $action = '';
        $action = $editAction;
        // if($admin->can('admin-delete')){
        //     $action .= $this->getDeleteButtonAttribute();
        // }
        $action .= $this->getDeleteButtonAttribute();
        

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
        return '<a href="' . route('admins.destroy', $this) . '" class="delete_action" data-method="delete" data-toggle="tooltip" data-original-title="Delete" data-animation="false"><img src="' . asset("app-assets/images/icons/icons8-remove-48.png") . '" width="30"></a>';
    }

    /**
     * Method getFullNameAttribute
     *
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        return $this->name;
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
                $status = '<a href="javascript:void(0)" class=""><span class="badge badge-danger status_update" data-user_id="' . $this->id . '" data-status="' . $this->status . '">' . self::STATUS[self::INACTIVE] . '</span></a>';
                break;
            default:
                $status = '<a href="javascript:void(0)" class=""><span class="badge badge-success status_update" data-user_id="' . $this->id . '" data-status="' . $this->status . '">' . self::STATUS[self::ACTIVE] . '</span></a>';
                break;
        }

        return $status;
    }

  public function role()
   {

      return $this->belongsTo(Role::class, 'users_roles', 'user_id', 'role_id');
   }
}

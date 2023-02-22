<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
   use HasFactory;
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

   protected $fillable = [
      'name',
      'slug',
      'permissions',
   ];

   /**
     * Method getActionAttribute
     *
     * @return string
     */
    public function getActionAttribute(): string
    {   
        $viewAction = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';
       $editAction = '<a href="'. route('roles.edit', $this->id).'" class="edit" data-toggle="tooltip" data-original-title="Edit" data-animation="false"><img src="'.asset("app-assets/images/icons/icons8-edit-64.png").'" width="20"></a>';
        
        
       $action = $editAction.$this->getDeleteButtonAttribute();
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
        return '<a href="'.route('roles.destroy', $this).'" class="delete_action" data-method="delete" data-toggle="tooltip" data-original-title="Delete" data-animation="false"><img src="'.asset("app-assets/images/icons/icons8-remove-48.png").'" width="30"></a>';
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
  
    public function getRoleAttribute(): string
    {
        $type = self::SUPERADMIN;

        switch($this->type)
        {
            case self::SUPERADMIN:
                $role = '<span class="badge badge-success">'.self::ROLE[self::SUPERADMIN].'</span>';
                break;
            default:
                $role = '<span class="badge badge-success">'.self::ROLE[self::ADMIN].'</span>';
                break;
        }

        return $role;
    }
   public function permissions()
   {

      return $this->belongsToMany(Permission::class, 'roles_permissions');
   }

   public function admins()
   {

      return $this->belongsToMany(Admin::class, 'users_roles', 'user_id', 'role_id');
   }
}

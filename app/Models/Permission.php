<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
         'name',
         'slug'
   ];
   /**
     * Method getActionAttribute
     *
     * @return string
     */
    public function getActionAttribute(): string
    {
       $viewAction = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';
       $editAction = '<a href="'. route('permissions.edit', $this->id).'" class="edit" data-toggle="tooltip" data-original-title="Edit" data-animation="false"><img src="'.asset("app-assets/images/icons/icons8-edit-64.png").'" width="20"></a>';
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
        return '<a href="'.route('permissions.destroy', $this).'" class="delete_action" data-method="delete" data-toggle="tooltip" data-original-title="Delete" data-animation="false"><img src="'.asset("app-assets/images/icons/icons8-remove-48.png").'" width="30"></a>';
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

    public function roles() {

        return $this->belongsToMany(Role::class,'roles_permissions');

     }

     public function admins() {

        return $this->belongsToMany(Admin::class,'admins_permissions');

     }
}

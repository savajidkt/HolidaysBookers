<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
    const ACTIVE = 1;
    const INACTIVE = 0;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
         'module',
         'name',
         'type',
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
       $editAction = '<a href="'. route('permissions.edit', $this->id).'" class="edit btn btn-info btn-sm" data-toggle="tooltip" data-original-title="Edit" data-animation="false"><i class="fa fa-edit" aria-hidden="true"></i></a> ';
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
        return '<a href="'.route('permissions.destroy', $this).'" class="delete_action btn btn-danger btn-sm" data-method="delete" data-toggle="tooltip" data-original-title="Delete" data-animation="false"><i class="fa fa-trash" aria-hidden="true"></i></a>';
    }

    /**
     * Method getFullNameAttribute
     *
     * @return string
     */
    public function getTypeNameAttribute(): string
    {    $type_name ='';
        if($this->type==1){
            $type_name = 'Create';
        }elseif($this->type==2){
            $type_name = 'Edit';
        }
        elseif($this->type==3){
            $type_name = 'Delete';
        }
        elseif($this->type==4){
            $type_name = 'View';
        }
        return $type_name;
    }

    public function roles() {

        return $this->belongsToMany(Role::class,'roles_permissions');

     }

     public function admins() {

        return $this->belongsToMany(Admin::class,'admins_permissions');

     }
}

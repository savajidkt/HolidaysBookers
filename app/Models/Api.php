<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Api extends Model
{
    use HasFactory;
    const ACTIVE = 1;
    const INACTIVE = 0;

    const STATUS = [
        self::ACTIVE => 'Active',
        self::INACTIVE => 'Inactive'
    ];

    protected $fillable = [
        'name',
        'api_url',
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
        $viewAction = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">'.__('core.view').'</a>';
        $editAction = '<a href="' . route('apis.edit', $this->id) . '" class="edit" data-toggle="tooltip" data-original-title="'.__('core.edit').'" data-animation="false"><img src="' . asset("app-assets/images/icons/icons8-edit-64.png") . '" width="20"></a>';


        if($admin->can('api-view')){
            //$action .= $viewAction;
        }
        //$action = $editAction;
        if($admin->can('api-edit')){
            $action .= $editAction;
        } 
    
        if($admin->can('api-delete')){
             $action .= $this->getDeleteButtonAttribute();
         }	
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
        return '<a href="' . route('apis.destroy', $this) . '" class="delete_action" data-method="delete" data-toggle="tooltip" data-original-title="'.__('core.delete').'" data-animation="false"><img src="' . asset("app-assets/images/icons/icons8-remove-48.png") . '" width="30"></a>';
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
                $status = '<a href="javascript:void(0)" class=""><span class="badge badge-danger status_update" data-api_id="' . $this->id . '" data-status="' . $this->status . '">' .__('core.inactive') . '</span></a>';
                break;
            default:
                $status = '<a href="javascript:void(0)" class=""><span class="badge badge-success status_update" data-api_id="' . $this->id . '" data-status="' . $this->status . '">'.__('core.active'). '</span></a>';
                break;
        }

        return $status;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
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
        'state_id',
        'country_id',   
        'rezlive_city_code',     
        'status'
    ];

    /**
     * Method getActionAttribute
     *
     * @return string
     */
    public function getActionAttribute(): string
    {
        $admin = auth()->user();
        $action ='';
        $viewAction = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">'.__('core.view').'</a>';
        $editAction = '<a href="' . route('cities.edit', $this->id) . '" class="edit btn btn-info btn-sm" data-toggle="tooltip" data-original-title="'.__('core.edit').'" data-animation="false"><i class="fa fa-edit" aria-hidden="true"></i></a> ';
        if($admin->can('location-view')){
            //$action .= $viewAction;
        }
        //$action = $editAction;
        if($admin->can('location-edit')){
            $action .= $editAction;
        } 
    
        if($admin->can('location-delete')){
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
        return '<a href="' . route('cities.destroy', $this) . '" class="delete_action btn btn-danger btn-sm" data-method="delete" data-toggle="tooltip" data-original-title="'.__('core.delete').'" data-animation="false"><i class="fa fa-trash" aria-hidden="true"></i></a>';
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
                $status = '<a href="javascript:void(0)" class=""><span class="badge badge-danger status_update" data-city_id="' . $this->id . '" data-status="' . $this->status . '">' . __('core.inactive') . '</span></a>';
                break;
            default:
                $status = '<a href="javascript:void(0)" class=""><span class="badge badge-success status_update" data-city_id="' . $this->id . '" data-status="' . $this->status . '">' .  __('core.active') . '</span></a>';
                break;
        }

        return $status;
    }
    
    public function state()
    { 
       return $this->belongsTo(State::class,'state_id', 'id');
    }
 
}

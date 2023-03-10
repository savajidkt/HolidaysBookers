<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reach extends Model
{
    use HasFactory;
    const ACTIVE = 1;
    const INACTIVE = 0;


    const STATUS = [
        self::ACTIVE => 'Active',
        self::INACTIVE => 'Inactive'
    ];



    protected $table = "reachus";
    protected $fillable = [
        'name',
        'show_other_textbox',
        'textbox_lable',
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
        $viewAction = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">' . __('core.view') . '</a>';
        $editAction = '<a href="' . route('reachus.edit', $this->id) . '" class="edit btn btn-info btn-sm" data-toggle="tooltip" data-original-title="' . __('core.edit') . '" data-animation="false"><i class="fa fa-edit" aria-hidden="true"></i></a> ';
        if($admin->can('reach-us-view')){
            //$action .= $viewAction;
        }
        if($admin->can('reach-us-edit')){
            $action .= $editAction;
        } 

        if($admin->can('reach-us-delete')){
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
        return '<a href="' . route('reachus.destroy', $this) . '" class="delete_action btn btn-danger btn-sm" data-method="delete" data-toggle="tooltip" data-original-title="' . __('core.delete') . '" data-animation="false"><i class="fa fa-trash" aria-hidden="true"></i></a>';
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
                $status = '<a href="javascript:void(0)" class=""><span class="badge badge-danger status_update" data-reach_id="' . $this->id . '" data-status="' . $this->status . '">' . __('core.inactive') . '</span></a>';
                break;
            default:
                $status = '<a href="javascript:void(0)" class=""><span class="badge badge-success status_update" data-reach_id="' . $this->id . '" data-status="' . $this->status . '">' . __('core.active') . '</span></a>';
                break;
        }
        return $status;
    }

    public function getShowOtherTextboxNameAttribute(): string
    {

        if ($this->show_other_textbox == 0) {
            return '<span class="badge badge-danger" >' . __('core.no') . '</span>';
        } else {
            return '<span class="badge badge-success" >' . __('core.yes') . '</span>';
        }
    }
}

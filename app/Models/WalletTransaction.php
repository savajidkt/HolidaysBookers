<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletTransaction extends Model
{
    use HasFactory;
    const CREDIT = 1;
    const DEBIT = 0;

    const TYPE = [
        self::CREDIT => 'Credit',
        self::DEBIT => 'Debit'
    ];

    protected $fillable = [
        'user_id',
        'agent_id',
        'transaction_type',
        'pnr',
        'amount',
        'type',
        'comment',
        'balance',
    ];

    /**
     * Method getActionAttribute
     *
     * @return string
     */
    public function getActionAttribute(): string
    {
        $viewAction = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">' . __('core.view') . '</a>';
        $editAction = '<a href="' . route('apis.edit', $this->id) . '" class="edit" data-toggle="tooltip" data-original-title="' . __('core.edit') . '" data-animation="false"><img src="' . asset("app-assets/images/icons/icons8-edit-64.png") . '" width="20"></a>';


        $action = $editAction . $this->getDeleteButtonAttribute();
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
        return '<a href="' . route('apis.destroy', $this) . '" class="delete_action" data-method="delete" data-toggle="tooltip" data-original-title="' . __('core.delete') . '" data-animation="false"><img src="' . asset("app-assets/images/icons/icons8-remove-48.png") . '" width="30"></a>';
    }


    /**
     * Method getStatusAttribute
     *
     * @return string
     */
    public function getTypeNameAttribute(): string
    {
        $type = self::CREDIT;

        switch ($this->type) {
            case self::DEBIT:
                $status = '<a href="javascript:void(0)" class=""><span class="badge badge-danger">DEBIT</span></a>';
                break;
            default:
                $status = '<a href="javascript:void(0)" class=""><span class="badge badge-success">CREDIT</span></a>';
                break;
        }

        return $status;
    }
}

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

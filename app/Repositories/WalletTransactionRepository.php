<?php

namespace App\Repositories;

use Exception;
use App\Models\User;
use App\Models\WalletTransaction;
use App\Exceptions\GeneralException;

class WalletTransactionRepository
{
    /**
     * Method create
     *
     * @param array $data [explicite description]
     *
     * @return WalletTransaction
     */
    public function create(array $data): WalletTransaction
    {
        $dataSave = [
            'user_id'        => $data['user_id'],
            'agent_id'        => $data['agent_id'],
            'transaction_type'     => $data['transaction_type'],
            'pnr'     => $data['pnr'],
            'amount'     => $data['amount'],
            'type'     => $data['type'],
            'comment'     => $data['comment'],
        ];

        $wallettransaction =  WalletTransaction::create($dataSave);
        return $wallettransaction;
    }

    /**
     * Method update
     *
     * @param array $data [explicite description]
     * @param WalletTransaction $wallettransaction [explicite description]
     *
     * @return WalletTransaction
     * @throws Exception
     */
    public function update(array $data, WalletTransaction $wallettransaction): WalletTransaction
    {
        $dataSave = [
            'user_id'        => $data['user_id'],
            'agent_id'        => $data['agent_id'],
            'transaction_type'     => $data['transaction_type'],
            'pnr'     => $data['pnr'],
            'amount'     => $data['amount'],
            'type'     => $data['type'],
            'comment'     => $data['comment'],
        ];


        if ($wallettransaction->update($dataSave)) {
            return $wallettransaction;
        }

        throw new Exception(__('wallettransaction/message.updated_error'));
    }

    /**
     * Method delete
     *
     * @param WalletTransaction $user [explicite description]
     *
     * @return bool
     * @throws Exception
     */
    public function delete(WalletTransaction $wallettransaction): bool
    {
        if ($wallettransaction->forceDelete()) {
            return true;
        }

        throw new Exception(__('wallettransaction/message.deleted_error'));
    }

    /**
     * Method changeStatus
     *
     * @param array $input [explicite description]
     *
     * @return bool
     */
    public function changeStatus(array $input, WalletTransaction $wallettransaction): bool
    {
        $wallettransaction->status = !$input['status'];
        return $wallettransaction->save();
    }


    public function updateCredit(array $data): WalletTransaction
    {
        $dataSave = [
            'user_id'        => $data['user_id'],
            'agent_id'        => $data['HBCredit_user_id'],
            'amount'     => numberFormat($data['amount']),
            'type'     => $data['type'],
            'comment'     => $data['comment'],
            'balance'     => numberFormat($data['balance']),
        ];

        $wallettransaction =  WalletTransaction::create($dataSave);
        return $wallettransaction;
    }
}

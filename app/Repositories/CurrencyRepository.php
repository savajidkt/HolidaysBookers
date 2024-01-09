<?php

namespace App\Repositories;

use App\Models\Currency;
use Exception;

class CurrencyRepository
{
    /**
     * Method create
     *
     * @param array $data [explicite description]
     *
     * @return Currency
     */

    public function create(array $data): Currency
    {
        $dataSave = [
            'country_id'    => $data['country_id'],
            'name'    => $data['name'],
            'code'    => $data['code'],
            'symbol'    => $data['symbol'],
            'rate'    => $data['rate'],
            'status'     => $data['status'],
        ];
        $currency =  Currency::create($dataSave);
        return $currency;
    }

    /**
     * Method update
     *
     * @param array $data [explicite description]
     * @param Currency $currency [explicite description]
     *
     * @return Currency
     * @throws Exception
     */
    public function update(array $data, Currency $currency): Currency
    {
        $dataSave = [
            'country_id'    => $data['country_id'],
            'name'    => $data['name'],
            'code'    => $data['code'],
            'symbol'    => $data['symbol'],
            'rate'    => $data['rate'],
            'status'     => $data['status'],
        ];
        
        if ($currency->update($dataSave)) {
            return $currency;
        }
        throw new Exception('Currency update failed!');
    }

    /**
     * Method delete
     *
     * @param Currency $user [explicite description]
     *
     * @return bool
     * @throws Exception
     */
    public function delete(Currency $currency): bool
    {
        if ($currency->delete()) {
            return true;
        }

        throw new Exception('Currency delete failed!');
    }

    /**
     * Method changeStatus
     *
     * @param array $input [explicite description]
     *
     * @return bool
     */
    public function changeStatus(array $input, Currency $currency): bool
    {
        $currency->status = !$input['status'];
        return $currency->save();
    }
}

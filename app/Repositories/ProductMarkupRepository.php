<?php

namespace App\Repositories;

use App\Models\ProductMarkup;
use Exception;

class ProductMarkupRepository
{
    /**
     * Method create
     *
     * @param array $data [explicite description]
     *
     * @return ProductMarkup
     */
    public function create(array $data): ProductMarkup
    {
        $dataSave = [
            'name'    => $data['name'],
            'percentage'    => $data['percentage'],
            'status'     => $data['status'],
        ];

        $productmarkup =  ProductMarkup::create($dataSave);
        return $productmarkup;
    }

    /**
     * Method update
     *
     * @param array $data [explicite description]
     * @param ProductMarkup $productmarkup [explicite description]
     *
     * @return ProductMarkup
     * @throws Exception
     */
    public function update(array $data, ProductMarkup $productmarkup): ProductMarkup
    {
        $dataSave = [
            'name'    => $data['name'],
            'percentage'    => $data['percentage'],
            'status'     => $data['status'],
        ];


        if ($productmarkup->update($dataSave)) {
            return $productmarkup;
        }

        throw new Exception(__('product-markup/message.updated_error'));
    }

    /**
     * Method delete
     *
     * @param ProductMarkup $user [explicite description]
     *
     * @return bool
     * @throws Exception
     */
    public function delete(ProductMarkup $productmarkup): bool
    {
        if ($productmarkup->forceDelete()) {
            return true;
        }

        throw new Exception(__('product-markup/message.deleted_error'));
    }

    /**
     * Method changeStatus
     *
     * @param array $input [explicite description]
     *
     * @return bool
     */
    public function changeStatus(array $input, ProductMarkup $productmarkup): bool
    {
        $productmarkup->status = !$input['status'];
        return $productmarkup->save();
    }
}

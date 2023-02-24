<?php

namespace App\Repositories;

use App\Models\CompanyType;
use Exception;

class CompanyTypeRepository
{
    /**
     * Method create
     *
     * @param array $data [explicite description]
     *
     * @return CompanyType
     */
    public function create(array $data): CompanyType
    {
        $dataSave = [
            'company_type'    => $data['company_type'],
            'status'     => $data['status'],
        ];

        $companytype =  CompanyType::create($dataSave);
        return $companytype;
    }

    /**
     * Method update
     *
     * @param array $data [explicite description]
     * @param CompanyType $companytype [explicite description]
     *
     * @return CompanyType
     * @throws Exception
     */
    public function update(array $data, CompanyType $companytype): CompanyType
    {
        $dataSave = [
            'company_type'    => $data['company_type'],
            'status'     => $data['status'],
        ];


        if ($companytype->update($dataSave)) {
            return $companytype;
        }

        throw new Exception(__('company-type/message.updated_error'));
    }

    /**
     * Method delete
     *
     * @param CompanyType $user [explicite description]
     *
     * @return bool
     * @throws Exception
     */
    public function delete(CompanyType $companytype): bool
    {
        if ($companytype->forceDelete()) {
            return true;
        }

        throw new Exception(__('company-type/message.deleted_error'));
    }

    /**
     * Method changeStatus
     *
     * @param array $input [explicite description]
     *
     * @return bool
     */
    public function changeStatus(array $input, CompanyType $companytype): bool
    {
        $companytype->status = !$input['status'];
        return $companytype->save();
    }
}

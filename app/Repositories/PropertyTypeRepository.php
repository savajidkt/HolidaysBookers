<?php

namespace App\Repositories;

use App\Models\PropertyType;
use Exception;

class PropertyTypeRepository
{
    /**
     * Method create
     *
     * @param array $data [explicite description]
     *
     * @return PropertyType
     */
    public function create(array $data): PropertyType
    {
        $dataSave = [
            'property_name'    => $data['property_name'],
            'status'     => $data['status'],
        ];

        $propertytype =  PropertyType::create($dataSave);
        return $propertytype;
    }

    /**
     * Method update
     *
     * @param array $data [explicite description]
     * @param PropertyType $propertytype [explicite description]
     *
     * @return PropertyType
     * @throws Exception
     */
    public function update(array $data, PropertyType $propertytype): PropertyType
    {
        $dataSave = [
            'property_name'    => $data['property_name'],
            'status'     => $data['status'],
        ];


        if ($propertytype->update($dataSave)) {
            return $propertytype;
        }

        throw new Exception(__('propertytype/message.updated_error'));
    }

    /**
     * Method delete
     *
     * @param PropertyType $user [explicite description]
     *
     * @return bool
     * @throws Exception
     */
    public function delete(PropertyType $propertytype): bool
    {
        if ($propertytype->forceDelete()) {
            return true;
        }

        throw new Exception(__('propertytype/message.deleted_error'));
    }

    /**
     * Method changeStatus
     *
     * @param array $input [explicite description]
     *
     * @return bool
     */
    public function changeStatus(array $input, PropertyType $propertytype): bool
    {
        $propertytype->status = !$input['status'];
        return $propertytype->save();
    }
    public function addPropertyPopup(array $data): PropertyType
    {
        $dataSave = [
            'property_name'    => $data['property_name'],
            'status'  => PropertyType::ACTIVE,
        ];

        $property =  PropertyType::create($dataSave);
        return $property;
    }
}

<?php

namespace App\Repositories;

use App\Models\MealPlan;
use Exception;

class MealPlanRepository
{
    /**
     * Method create
     *
     * @param array $data [explicite description]
     *
     * @return MealPlan
     */

    public function create(array $data): MealPlan
    {
        $dataSave = [
            'name'    => $data['name'],
            'status'     => $data['status'],
        ];
        $mealplan =  MealPlan::create($dataSave);
        return $mealplan;
    }

    /**
     * Method update
     *
     * @param array $data [explicite description]
     * @param MealPlan $mealplan [explicite description]
     *
     * @return MealPlan
     * @throws Exception
     */
    public function update(array $data, MealPlan $mealplan): MealPlan
    {
        $dataSave = [
            'name'    => $data['name'],
            'status'     => $data['status'],
        ];
        if ($mealplan->update($dataSave)) {
            return $mealplan;
        }
        throw new Exception('Meal plan update failed!');
    }

    /**
     * Method delete
     *
     * @param MealPlan $user [explicite description]
     *
     * @return bool
     * @throws Exception
     */
    public function delete(MealPlan $mealplan): bool
    {
        if ($mealplan->delete()) {
            return true;
        }

        throw new Exception('Meal plan delete failed!');
    }

    /**
     * Method changeStatus
     *
     * @param array $input [explicite description]
     *
     * @return bool
     */
    public function changeStatus(array $input, MealPlan $mealplan): bool
    {
        $mealplan->status = !$input['status'];
        return $mealplan->save();
    }


    public function addMealPlansPopup(array $data): MealPlan
    {
        $dataSave = [
            'name'    => $data['name'],
            'status'     => 1,
        ];
        $roomtype =  MealPlan::create($dataSave);
        return $roomtype;
    }
}

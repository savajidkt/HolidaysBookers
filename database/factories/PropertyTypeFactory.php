<?php

namespace Database\Factories;
use App\Models\PropertyType;
use Illuminate\Support\Str;

use Illuminate\Database\Eloquent\Factories\Factory;

class PropertyTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = PropertyType::class;
    public function definition()
    {
        return [
            'property_name' => $this->faker->name,
            'status'=>1,
        ];
    }
}

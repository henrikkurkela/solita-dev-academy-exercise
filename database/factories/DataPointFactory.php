<?php

namespace Database\Factories;

use App\Models\Farm;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class DataPointFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'farm_id' => Farm::factory(),
            'datetime' => $this->faker->dateTime(),
            'sensortype' => 'temperature',
            'value' => '10.00'
        ];
    }
}

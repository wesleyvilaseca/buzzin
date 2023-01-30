<?php

namespace Database\Factories;

use App\Models\Plan;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

    protected $model = Plan::class;

    public function definition()
    {
        return [
            'name' => $this->faker->unique()->name(),
            'price' => 89.0,
            'description' => $this->faker->sentence()
        ];
    }
}

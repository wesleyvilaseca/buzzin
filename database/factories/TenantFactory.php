<?php

namespace Database\Factories;

use App\Models\Plan;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

class TenantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

    protected $model = Tenant::class;

    public function definition()
    {
        return [
            'plan_id' => Plan::factory(),
            'cnpj' => uniqid() . date('YmdHis'),
            'name' => $this->faker->unique()->name(),
            'email' => $this->faker->unique()->email()
        ];
    }
}

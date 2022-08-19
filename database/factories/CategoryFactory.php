<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

    protected $model = Category::class;

    public function definition()
    {
        return [
            'tenant_id' => Tenant::factory(),
            'name' => $this->faker->unique()->name(),
            'description' => $this->faker->sentence()
        ];
    }
}

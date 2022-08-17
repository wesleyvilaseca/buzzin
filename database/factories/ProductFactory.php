<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

    protected $model = Product::class;

    public function definition()
    {
        return [
            'tenant_id' => Product::factory(),
            'title' => $this->faker->unique()->name(),
            'description' => $this->faker->sentence(),
            'image' => 'pizza.png',
            'price' => 12.3
        ];
    }
}

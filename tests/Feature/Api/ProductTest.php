<?php

namespace Tests\Feature\Api;

use App\Models\Product;
use App\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    /**
     * Error Get All Products
     *
     * @return void
     */
    public function testErrorGetAllProducts()
    {
        $tenant = 'fake_value';

        $response = $this->getJson("/api/v1/products?uuid={$tenant}");

        $response->assertStatus(422);
    }

    /**
     * Get All Products
     *
     * @return void
     */
    public function testGetAllProducts()
    {
        $tenant = Tenant::factory()->create();

        $response = $this->getJson("/api/v1/products?uuid={$tenant->uuid}");

        $response->assertStatus(200);
    }

    /**
     * Produt Not Found (404)
     *
     * @return void
     */
    public function testNotFoundProduct()
    {
        $tenant = Tenant::factory()->create();
        $product = 'fake_value';

        $response = $this->getJson("/api/v1/products/{$product}?uuid={$tenant->uuid}");

        $response->assertStatus(404);
    }

    /**
     * Get Product by Identify
     *
     * @return void
     */
    public function testGetProductByIdentify()
    {
        $tenant = Tenant::factory()->create();
        $product = Product::factory()->create();

        $response = $this->getJson("/api/v1/products/{$product->uuid}?uuid={$tenant->uuid}");

        $response->assertStatus(200);
    }
}

<?php

namespace Tests\Feature\Api;

use App\Models\Category;
use App\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    /**
     * error get Categories by Tenant
     *
     * @return void
     */
    public function testGetErrorCategoriesByTenant()
    {
        $response = $this->getJson('/api/v1/categories');
        // $response->dump();

        $response->assertStatus(422);
    }

    /**
     * get Categories by Tenant
     *
     * @return void
     */
    public function testGetCategoriesByTenant()
    {
        $tenant = Tenant::factory()->create();
        // $tenant->dump();

        $response = $this->getJson("/api/v1/categories?uuid={$tenant->uuid}");

        $response->assertStatus(200);
    }

    /**
     * get error Category by Tenant
     *
     * @return void
     */
    public function testErrorGetCategoryByTenant()
    {
        $category = 'fake_value';
        $tenant = Tenant::factory()->create();
        // $tenant->dump();

        $response = $this->getJson("/api/v1/categories/{$category}?uuid={$tenant->uuid}");

        $response->assertStatus(404);
    }


    /**
     * get Category by Tenant
     *
     * @return void
     */
    public function testGetCategoryByTenant()
    {
        $tenant = Tenant::factory()->create();
        // $tenant->dump();

        $category = Category::factory()->create();
        var_dump("/api/v1/categories/{$category->uuid}?uuid={$tenant->uuid}");
       
        $response = $this->getJson("/api/v1/categories/{$category->url}?uuid={$tenant->uuid}");

        $response->assertStatus(200);
    }
}

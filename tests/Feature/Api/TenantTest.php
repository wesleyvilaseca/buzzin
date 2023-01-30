<?php

namespace Tests\Feature\Api;

use App\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TenantTest extends TestCase
{
    /**
     * Test get all tenants
     *
     * @return void
     */
    public function testGetAllTenants()
    {
        Tenant::factory(10)->create();
        $response = $this->getJson('/api/v1/tenants');
        // $response->dump();

        $response->assertStatus(200)->assertJsonCount(10, 'data');
    }

     /**
     * Test get error single tenant
     *
     * @return void
     */
    public function testErrorGetSingleTenant()
    {
        $tenant = 'fake_value';

        $response = $this->getJson("/api/v1/tenants/{$tenant}");
        $response->assertStatus(404);
    }

    /**
     * Test get single tenant
     *
     * @return void
     */
    public function testGetSingleTenant()
    {
        $tenant = Tenant::factory()->create();

        // $tenant->dump();

        $response = $this->getJson("/api/v1/tenants/{$tenant->uuid}");
        $response->assertStatus(200);
    }
}

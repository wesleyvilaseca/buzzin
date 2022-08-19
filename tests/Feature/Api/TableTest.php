<?php

namespace Tests\Feature\Api;

use App\Models\Table;
use App\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TableTest extends TestCase
{
    /**
     * error get Tables by Tenant
     *
     * @return void
     */
    public function testGetErrorTablesByTenant()
    {
        $response = $this->getJson('/api/v1/tables');
        // $response->dump();

        $response->assertStatus(422);
    }

    /**
     * get Tables by Tenant
     *
     * @return void
     */
    public function testGetTablesByTenant()
    {
        $tenant = Tenant::factory()->create();
        // $tenant->dump();

        $response = $this->getJson("/api/v1/tables?uuid={$tenant->uuid}");

        $response->assertStatus(200);
    }

    /**
     * get error Table by Tenant
     *
     * @return void
     */
    public function testErrorGetTableByTenant()
    {
        $table = 'fake_value';
        $tenant = Tenant::factory()->create();
        // $tenant->dump();

        $response = $this->getJson("/api/v1/tables/{$table}?uuid={$tenant->uuid}");

        $response->assertStatus(404);
    }

    /**
     * get Table by Tenant
     *
     * @return void
     */
    public function testGetTableByTenant()
    {
        $tenant = Tenant::factory()->create();
        // $tenant->dump();

        $table = Table::factory()->create();
       
        $response = $this->getJson("/api/v1/tables/{$table->uuid}?uuid={$tenant->uuid}");

        $response->assertStatus(200);
    }
}

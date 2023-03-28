<?php

namespace Database\Seeders;

use App\Models\Plan;
use App\Models\Tenant;
use Illuminate\Database\Seeder;

class TenantsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $plan = Plan::first();

        $plan->tenants()->create([
            'cnpj' => '24074848000181',
            'name' => 'buzzingame',
            'url'  => 'buzzingame',
            'email' => 'buzzingame@buzzin.com.br'
        ]);
    }
}

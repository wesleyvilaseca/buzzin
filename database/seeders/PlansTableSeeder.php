<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Plan::insert([
            [
                'name' => 'Plano mensal',
                'url' => 'plano-mensal',
                'price' => 100.00,
                'description' => 'Plano Mensal'
            ],
            [
                'name' => 'Plano trimestral',
                'url' => 'plano-trimestral',
                'price' => 270.00,
                'description' => 'Plano trimestral'
            ],
            [
                'name' => 'Plano semestral',
                'url' => 'plano-semestral',
                'price' => 540.00,
                'description' => 'Plano semestral'
            ]
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Shipping;
use Illuminate\Database\Seeder;

class ShippmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Shipping::insert([
            [
                'description' => 'Delivery',
                'status' => 1,
                'alias' => 'delivery'
            ],
            [
                'description' => 'Retirada',
                'status' => 1,
                'alias' => 'getonstore'
            ]
        ]);
    }
}

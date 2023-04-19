<?php

namespace Database\Seeders;

use App\Models\Payment;
use Illuminate\Database\Seeder;

class PaymentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Payment::create(
            [
            'description' => 'Cartão de Crédido/Débito (na entrega)',
            'ismoney' => 0,
            'status' => 1
            ],
            [
                'description' => 'Pagar na Retirada',
                'ismoney' => 0,
                'status' => 1
            ],
            [
                'description' => 'Pagar com Mercado Pago',
                'integration' => 'MercadoPago',
                'ismoney' => 0,
                'status' => 1
            ],
            [
                'description' => 'Pagar em Dinheiro',
                'ismoney' => 1,
                'status' => 1
            ]
    );
    }
}

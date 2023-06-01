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
        $payments = [
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
                'route_base' => 'payment_integration.mercadopago',
                'ismoney' => 0,
                'status' => 1
            ],
            [
                'description' => 'Pagar em Dinheiro',
                'ismoney' => 1,
                'status' => 1
            ]
        ];

        collect($payments)->each(function ($payment) {
            Payment::create($payment);
        });
    }
}

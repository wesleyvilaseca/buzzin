<?php

namespace Database\Seeders;

use App\Models\OperationDay;
use Illuminate\Database\Seeder;

class OperationDaysTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OperationDay::create(
            [
                'description' => 'Segunda-Feira',
            ],
            [
                'description' => 'Terca-Feira',
            ],
            [
                'description' => 'Quarta-Feira',
            ],
            [
                'description' => 'Quinta-Feira',
            ],
            [
                'description' => 'Sexta-Feira',
            ],
            [
                'description' => 'Sábado',
            ],
            [
                'description' => 'Domingo',
            ],
        );
    }
}

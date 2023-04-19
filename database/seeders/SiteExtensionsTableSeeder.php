<?php

namespace Database\Seeders;

use App\Models\SiteExtensions;
use Illuminate\Database\Seeder;

class SiteExtensionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SiteExtensions::create(
            [
                'description' => 'Modo catálogo',
                'detail' => 'Essa funcionalidade desabilita a venda online de seu website, tornando o website em um catalogo online',
                'route_base' => 'admin.extension_site.catalog',
                'tag' => 'catalog',
                'free' => 1,
                'status' => 1
            ],
            [
                'description' => 'Balão do whatsapp',
                'detail' => 'Icone flutuante do whatsapp no rodapé do site',
                'route_base' => 'admin.extension_site.whatsapp',
                'tag' => 'whatsapp',
                'free' => 1,
                'status' => 1
            ]
        );
    }
}

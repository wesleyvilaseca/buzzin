<?php

namespace App\Models;

use App\Tenant\Traits\TenantTrait;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Zone extends Model {
    use HasFactory;
    use TenantTrait;
    use SpatialTrait;

    protected $fillable = ['name', 'coordinates', 'data', 'delivery_time_ini', 'delivery_time_end', 'active', 'type', 'free', 'free_when', 'time_type'];

    protected $spatialFields = [
        'coordinates'
    ];
    // public function buscaCoordenada($latitude, $longitude) {
    //     $coord = [$latitude, $longitude];
    //     $result = DB::table('table_name')
    //         ->whereRaw('JSON_CONTAINS(coordinates, ?)', [json_encode($coord)])
    //         ->get();

    //     $shape = DB::table('sua_tabela')
    //         ->whereRaw("JSON_CONTAINS(coordenates, '" . json_encode($coord) . "', '$')")
    //         ->first();
    // }

    // public function another() {
    //     // Obtenha todos os registros da tabela com as coordenadas
    //     $records = DB::table('table_name')->get();

    //     // Converte as coordenadas em um array PHP usando o método "json_decode"
    //     foreach ($records as $record) {
    //         $coordinates = json_decode($record->coordinates, true);

    //         // Verifica se a coordenada está dentro do shape usando o algoritmo de ponto dentro de polígono
    //         if (isPointInsidePolygon($coordinates, $searchedCoordinate)) {
    //             // Se a coordenada estiver dentro do shape, retorne o registro correspondente
    //             return $record;
    //         }
    //     }

    //     // Retorne null se a coordenada não estiver dentro de nenhum shape
    //     return null;
    // }
}

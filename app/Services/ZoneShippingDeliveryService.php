<?php

namespace App\Services;

use App\Models\TenantShipping;
use App\Models\TenantSiteZoneDelivery;
use Exception;
use Grimzy\LaravelMysqlSpatial\Types\Point;

class ZoneShippingDeliveryService
{
    protected $cepAbertoService;

    public function __construct(
        CepAbertoService $cepAbertoService
    ) {
        $this->cepAbertoService = $cepAbertoService;
    }

    public function getShippingDeliveryDetailByCep(array $data, TenantShipping $tenantShipping)
    {
        try {
            $cepInfo = $this->cepAbertoService->getCep($data['cep']);
            $hasCepInfo = @$cepInfo->latitude && @$cepInfo->longitude;
            if (!$hasCepInfo) {
                return null;
            }

            $coordinate = new Point($cepInfo->latitude, $cepInfo->longitude);
            $shape = TenantSiteZoneDelivery::whereRaw("ST_Within(POINT(?,?), coordinates)", [$coordinate->getLng(), $coordinate->getLat()])->first();

            $hasShapeAndIsActive = $shape && $shape->active == 1;
            if (!$hasShapeAndIsActive) {
                return null;
            }

            $getTimeUnd = function (int $val): string {
                switch ($val) {
                    case 1:
                        return "minutos";
                    case 2:
                        return "horas";
                    case 3:
                        return "dias";
                }
            };

            $getDeliveryPrice = function ($data, $cartPrice) {
                if (!$data->free_when) {
                    return $data->price;
                }

                if ($cartPrice >= $data->free_when) {
                    return 0.00;
                }

                return $data->price;
            };

            return (object) [
                'description' => $tenantShipping->shipping()->first()->description,
                'price' => $getDeliveryPrice($shape, $data['cartPrice']),
                'alias' => $tenantShipping->shipping()->first()->alias,
                'estimation' => (object)[
                    "location" => $cepInfo->bairro,
                    "time_ini" => $shape->delivery_time_ini,
                    "time_end" => $shape->delivery_time_end,
                    "time_unid" => $getTimeUnd($shape->time_type)
                ]
            ];
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}

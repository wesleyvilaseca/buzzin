<?php

namespace App\Services;

use App\Models\Plan;
use App\Models\Shipping;
use App\Models\Tenant;
use App\Models\TenantSiteZoneDelivery;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use App\Repositories\Contracts\TenantRepositoryInterface;
use Exception;
use Grimzy\LaravelMysqlSpatial\Types\Point;

class TenantService
{
    private $plan, $data = [];
    private $repository;
    private $cepAbertoService;

    public function __construct(
        TenantRepositoryInterface $repository,
        CepAbertoService $cepAbertoService
    ) {
        $this->repository = $repository;
        $this->cepAbertoService = $cepAbertoService;
    }

    public function getAllTenants(int $per_page)
    {
        return $this->repository->getAllTenants($per_page);
    }

    public function getTenantByUuid(string $uuid)
    {
        return $this->repository->getTenantByUuid($uuid);
    }

    public function getTenantByFlag(string $flag)
    {
        return $this->repository->getTenantByFlag($flag);
    }

    public function make(Plan $plan, array $data)
    {
        $this->plan = $plan;
        $this->data = $data;

        $exist = Tenant::where('email', $this->data['email'])->orWhere('cnpj', $this->data['cnpj'])->first();
        if ($exist)
            return Redirect::back()->with('warning', 'Já existe um cadastro com as credênciais informadas');

        $exist = User::where('email', $this->data['email'])->first();
        if ($exist)
            return Redirect::back()->with('warning', 'Já existe um cadastro com as credênciais informadas');

        $tenant = $this->storeTenant();

        if (!$tenant)
            return Redirect::back()->with('error', 'Erro na operação, tente novamente');


        $user = $this->storeUser($tenant);

        if (!$user)
            return Redirect::back()->with('error', 'Erro na operação, tente novamente');

        return $user;
    }

    public function storeTenant()
    {
        $data = $this->data;

        return $this->plan->tenants()->create(
            [
                'cnpj' => $data['cnpj'],
                'name' => $data['tenant_name'],
                'address' => $data['address'],
                'state' => $data['state'],
                'zip_code' => $data['zip_code'],
                'district' => $data['district'],
                'city' => $data['city'],
                'number' => @$data['number'] ? $data['number'] : null,
                'email' => $data['email'],
                'subscription' => now(),
                'expires_at' => now()->addDay(7)
            ]
        );
    }

    public function storeUser($tenant)
    {
        $data = $this->data;

        return $tenant->users()->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password'  => Hash::make($data['password']),
        ]);
    }

    public function deliveryValue(array $data, string $tenantUrl)
    {
        $tenant = $this->getTenantByFlag($tenantUrl);

        if (!$tenant) {
            return response()->json(['message' => 'Empresa não localizada'], 404);
        }

        $tenantShipping = $tenant->tenantShipping()->where('status', 1)->get();

        if ($tenantShipping->isEmpty()) {
            return response()->json(['message' => 'Não há metodos de entrega disponível'], 404);
        }

        $shippingMethods = [];

        $getOnStore = $tenantShipping->where('shipping_id', 2)->first();
        if ($getOnStore) {
            $shippingMethod = Shipping::find($getOnStore->shipping_id);
            $shippingMethods[] = (object) [
                'description' => $shippingMethod->description,
                'price' => numberFormat(0.00)
            ];
        }

        $makeDelivery = $tenantShipping->where('shipping_id', 1)->first();
        if ($makeDelivery) {
            try {
                $shippingMethod = Shipping::find($makeDelivery->shipping_id);

                $cepInfo = $this->cepAbertoService->getCep($data['cep']);

                $coordinate = new Point($cepInfo->latitude, $cepInfo->longitude);
                $shape = TenantSiteZoneDelivery::whereRaw("ST_Within(POINT(?,?), coordinates)", [$coordinate->getLng(), $coordinate->getLat()])->first();

                if ($shape && $shape->active == 1) {
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
                            return numberFormat($data->price);
                        }

                        if ($cartPrice >= $data->free_when) {
                            return numberFormat(0.00);
                        }

                        return numberFormat($data->price);
                    };

                    $shippingMethods[] = (object) [
                        'description' => $shippingMethod->description,
                        'price' => $getDeliveryPrice($shape, $data['cartPrice']),
                        'estimation' => (object)[
                            "location" => $cepInfo->bairro,
                            "time_ini" => $shape->delivery_time_ini,
                            "time_end" => $shape->delivery_time_end,
                            "time_unid" => $getTimeUnd($shape->time_type)
                        ]
                    ];
                }
            } catch (Exception $e) {
                return response()->json(['message' => 'Houve um erro na requisição, tente novamento'], 404);
            }
        }

        return response()->json($shippingMethods, 200);
    }
}

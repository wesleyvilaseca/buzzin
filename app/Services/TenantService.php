<?php

namespace App\Services;

use App\Http\Resources\TenantPaymentResource;
use App\Models\Plan;
use App\Models\Shipping;
use App\Models\Tenant;
use App\Models\TenantSiteZoneDelivery;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use App\Repositories\Contracts\TenantRepositoryInterface;
use Carbon\Carbon;
use Error;
use Exception;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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

    public function getTenantById(int $id)
    {
        return $this->repository->getById($id);
    }

    public function make(Plan $plan, array $data)
    {
        $this->plan = $plan;
        $this->data = $data;

        $this->validate();

        $tenant = $this->storeTenant();
        if (!$tenant) {
            throw new Exception('Erro na operação, tente novamente');
        }

        $user = $this->storeUser($tenant);

        if (!$user) {
            throw new Exception('Erro na operação, tente novamente');
        }

        return $user;
    }

    public function updateTenant(Plan $plan, array $data, int $id)
    {
        $this->plan = $plan;
        $this->data = $data;
        $tenant = $this->getTenantById($id);

        $tenant->plan_id = $this->plan->id;
        $tenant->cnpj = @$this->data['cnpj'];
        $tenant->name = @$this->data['tenant_name'];
        $tenant->subscription = @$this->data['subscription'];
        $tenant->expires_at =  @$this->data['expires_at'];
        $tenant->subscription_active = @$this->data['subscription_active'];
        $tenant->subscription_id = @$this->data['subscription_id'];
        $tenant = $tenant->update();

        if (!$tenant) {
            throw new Exception('Erro na operação, tente novamente');
        }

        $dataUser = [];
        $dataUser['name'] = $this->data['name'];
        $dataUser['email'] = $this->data['email'];
        if ($this->data['password']) {
            $dataUser['password'] = Hash::make($this->data['password']);
        }

        try {
            $user = User::where('email', $this->data['email'])->update($dataUser);
        } catch (Exception $e) {
            throw new Exception('Erro na operação, tente novamente');
        }

        return $user;
    }

    private function validate()
    {
        $exist = Tenant::where('email', $this->data['email'])->orWhere('cnpj', $this->data['cnpj'])->first();
        if ($exist) {
            throw new Exception('Já existe um cadastro com as credênciais informadas');
        }

        $cnpj_is_valid = validaCNPJ($this->data['cnpj']);
        if (!$cnpj_is_valid) {
            throw new Exception('O CNPJ informado é inválido');
        }

        $exist = User::where('email', $this->data['email'])->first();
        if ($exist) {
            throw new Exception('Já existe um cadastro com as credênciais informadas');
        }
    }

    public function storeTenant()
    {
        $data = $this->data;

        return $this->plan->tenants()->create(
            [
                'cnpj' => @$data['cnpj'],
                'name' => @$data['tenant_name'],
                'email' => @$data['email'],
                'subscription' => !empty($data['subscription']) ? $data['subscription'] : now(),
                'expires_at' => !empty($data['expires_at']) ? $data['expires_at'] : now()->addDay(7),
                'subscription_active' =>  1
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

    public function checkSubscription()
    {
        $tenant = Auth::user()->tenant;
        $isSuper = User::where('email', $tenant->email)->first()?->super_admin == 'Y';
        if (!$isSuper) {
            if ($tenant->expires_at < Carbon::today()) {
                $tenant->update(['subscription_active' => 0]);
            } else {
                if ($tenant->subscription_active == 0) {
                    $tenant->update(['subscription_active' => 1]);
                }
            }
        }
    }

    public function subscriptionIsActive()
    {
        return Auth::user()->tenant->subscription_active;
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
                            return $data->price;
                        }

                        if ($cartPrice >= $data->free_when) {
                            return 0.00;
                        }

                        return $data->price;
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

    public function paymentMethos(array $selectedShippingMethod, string $tenantUrl)
    {
        $tenant = $this->getTenantByFlag($tenantUrl);

        if (!$tenant) {
            return response()->json(['message' => 'Empresa não localizada'], 404);
        }

        $tenantPayments = $tenant->tenantPaymentMethods()->where('status', 1)->get();
        if ($tenantPayments->isEmpty()) {
            return response()->json(['message' => 'Não há metodos de pagamento disponível'], 404);
        }

        $selectedShippingMethod = Str::kebab($selectedShippingMethod['description']);

        if ($selectedShippingMethod == 'retirada') {
            foreach ($tenantPayments as $key => $paymentMethod) {
                $paymentMethodDescription = Str::kebab($paymentMethod->payment->description);
                if ($paymentMethodDescription !== 'pagar-na-retirada') {
                    unset($tenantPayments[$key]);
                }
            }
        }

        if ($selectedShippingMethod == 'delivery') {
            foreach ($tenantPayments as $key => $paymentMethod) {
                $paymentMethodDescription = Str::kebab($paymentMethod->payment->description);
                if ($paymentMethodDescription == 'pagar-na-retirada') {
                    unset($tenantPayments[$key]);
                    break;
                }
            }
        }

        $data = TenantPaymentResource::collection($tenantPayments);

        return response()->json($data);
    }

    public function updateAssignatureRenew($subscription_id, Plan $plan) {
        if ($plan->url === 'plano-mensal') {
            $newExpiresDate = Carbon::now()->addMonths(1)->toDateString();
        }

        if ($plan->url === 'plano-trimestral') {
            $newExpiresDate = Carbon::now()->addMonths(3)->toDateString();
        }

        if ($plan->url === 'plano-semestral') {
            $newExpiresDate = Carbon::now()->addMonths(6)->toDateString();
        }
        try{
            Tenant::where('uuid', Auth::user()->tenant->uuid)->update([
                'subscription_id' => $subscription_id,
                'subscription' => Carbon::now()->toDateString(),
                'expires_at' => $newExpiresDate,
                'subscription_active' => 1
            ]);
        }catch(Exception $e) {
            throw new Error($e->getMessage());
        }
        
    }
}

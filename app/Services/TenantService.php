<?php

namespace App\Services;

use App\Models\Plan;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use App\Repositories\Contracts\TenantRepositoryInterface;


class TenantService
{
    private $plan, $data = [];
    private $repository;

    public function __construct(
        TenantRepositoryInterface $repository
    ) {
        $this->repository = $repository;
    }

    public function getAllTenants(int $per_page)
    {
        return $this->repository->getAllTenants($per_page);
    }

    public function getTenantByUuid(string $uuid)
    {
        return $this->repository->getTenantByUuid($uuid);
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
}

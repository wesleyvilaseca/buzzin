<?php

namespace App\Repositories;

use App\Models\Tenant;
use App\Repositories\Contracts\TenantRepositoryInterface;

class TenantRepository implements TenantRepositoryInterface
{
    protected $entity;

    public function __construct(Tenant $tenant)
    {
        $this->entity = $tenant;
    }

    public function getAllTenants(int $per_page)
    {
        return $this->entity->paginate($per_page);
    }

    public function getTenantByUuid(string $uuid)
    {
        return $this->entity->where('uuid', $uuid)->first();
    }

    public function getTenantByFlag(string $flag)
    {
        return $this->entity->where('url', $flag)->first();
    }

    public function getById(int $id)
    {
        return $this->entity->find($id);
    }
}

<?php

namespace App\Services;

use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Repositories\Contracts\TenantRepositoryInterface;

class CategoryService
{
    protected $tenantRepositoryInterface;
    protected $categoryRepositoryInterface;

    public function __construct(
        TenantRepositoryInterface $tenantRepositoryInterface,
        CategoryRepositoryInterface $categoryRepositoryInterface
    ) {
        $this->tenantRepositoryInterface = $tenantRepositoryInterface;
        $this->categoryRepositoryInterface = $categoryRepositoryInterface;
    }

    public function categories(string $uuid)
    {
        $tenant = $this->tenantRepositoryInterface->getTenantByUuid($uuid);
        return $this->categoryRepositoryInterface->categoriesByTenantId($tenant->id);
    }
}

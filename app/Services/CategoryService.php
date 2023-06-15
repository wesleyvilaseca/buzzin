<?php

namespace App\Services;

use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Repositories\Contracts\TenantRepositoryInterface;
use Exception;
use GuzzleHttp\Client;

class CategoryService
{
    protected $tenantRepositoryInterface;
    protected $categoryRepositoryInterface;
    protected $httpClient;

    public function __construct(
        TenantRepositoryInterface $tenantRepositoryInterface,
        CategoryRepositoryInterface $categoryRepositoryInterface
    ) {
        $this->tenantRepositoryInterface = $tenantRepositoryInterface;
        $this->categoryRepositoryInterface = $categoryRepositoryInterface;
        $this->httpClient = new Client();
    }

    public function categories(string $uuid)
    {
        $tenant = $this->tenantRepositoryInterface->getTenantByUuid($uuid);
        return $this->categoryRepositoryInterface->categoriesByTenantId($tenant->id);
    }

    public function getCategoryByUuid(string $uuid)
    {
        return $this->categoryRepositoryInterface->getCategoryByUuid($uuid);
    }

    public function getCategoryByUrl(string $url)
    {
        return $this->categoryRepositoryInterface->getCategoryByUrl($url);
    }
}

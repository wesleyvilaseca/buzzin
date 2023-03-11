<?php

namespace App\Repositories\Contracts;

interface TenantRepositoryInterface
{
    public function getAllTenants(int $per_page);
    public function getTenantByUuid( string $uuid );
    public function getTenantByFlag(string $flag);
    public function getById(int $id);
}

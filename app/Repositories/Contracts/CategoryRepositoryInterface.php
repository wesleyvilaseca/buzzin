<?php

namespace App\Repositories\Contracts;

interface CategoryRepositoryInterface
{
    public function categories(string $uuid);
    public function categoriesByTenantId(string $id);
    public function getCategory();
}

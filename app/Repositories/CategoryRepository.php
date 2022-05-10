<?php

namespace App\Repositories;
use App\Models\Category;

use App\Repositories\Contracts\CategoryRepositoryInterface;
use Illuminate\Support\Facades\DB;

class CategoryRepository implements CategoryRepositoryInterface
{
    
    protected $table;

    public function __construct()
    {
        $this->table = 'categories';
    }

    public function categories(string $uuid)
    {
        return DB::table($this->table)
        ->join('tenants', 'tenants.id', '=', 'categories.tenant_id')
        ->where('tenants.uuid', $uuid)
        ->select('categories.*')
        ->paginate();
    }

    public function categoriesByTenantId(string $id)
    {
        return DB::table($this->table)->where('tenant_id', $id)->paginate();
    }

    public function getCategory()
    {

    
    }
}

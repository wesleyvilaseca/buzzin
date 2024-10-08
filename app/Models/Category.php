<?php

namespace App\Models;

use App\Tenant\Observers\TenantObserver;
use App\Tenant\Traits\TenantTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    use TenantTrait;

    protected $fillable = ['name', 'url', 'description', 'icon', 'image'];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function search($filter = null)
    {
        $results = $this->where([
            ['name', 'LIKE', "%{$filter}%"],
            // ['tenant_id', '=', auth()->user()->tenant_id]
        ])
            ->orWhere([
                ['description', 'LIKE', "%{$filter}%"],
                // ['tenant_id', '=', auth()->user()->tenant_id]
            ])
            ->paginate();

        return $results;
    }
}

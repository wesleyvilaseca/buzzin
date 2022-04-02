<?php

namespace App\Models;

use App\Tenant\Traits\TenantTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;
    use TenantTrait;

    protected $fillable = ['identify', 'description'];

    public function search($filter = null)
    {
        $results = $this->where([
            ['identify', 'LIKE', "%{$filter}%"],
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

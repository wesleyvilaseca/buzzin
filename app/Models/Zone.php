<?php

namespace App\Models;

use App\Tenant\Traits\TenantTrait;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Zone extends Model {
    use HasFactory;
    use TenantTrait;
    use SpatialTrait;

    protected $fillable = ['name', 'autocomplete', 'coordinates', 'data', 'delivery_time_ini', 'delivery_time_end', 'active', 'type', 'free', 'free_when', 'time_type'];

    protected $spatialFields = [
        'coordinates'
    ];
}

<?php

namespace App\Models;

use App\Tenant\Traits\TenantTrait;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TenantSiteZoneDelivery extends Model {
    use HasFactory;
    use SpatialTrait;

    protected $table = 'zones';

    protected $spatialFields = [
        'coordinates'
    ];
}

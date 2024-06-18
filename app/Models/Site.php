<?php

namespace App\Models;

use App\Tenant\Traits\TenantTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    use TenantTrait;
    use HasFactory;

    const STATUS_DOMAIN_WAITING_APROVE = 0;
    const STATUS_DOMAIN_APROVED = 1;
    const STATUS_DOMAIN_DISABLED = 2;

    const IN_MAINTENCE = 1;
    const NOT_MAINTENCE = 0;

    /**
     * this status is to subdomain
     */
    const STATUS_WAITING = 0;
    const STATUS_APROVED = 1;
    const STATUS_DISABLED = 2;

    protected $fillable = ['domain', 'subdomain', 'url', 'data', 'maintence', 'status', 'status_domain'];

    /**
     * Define an accessor to cast the 'data' column to an object.
     *
     * @param  string  $value
     * @return mixed
     */
    public function getDataAttribute($value)
    {
        return json_decode($value);
    }
}

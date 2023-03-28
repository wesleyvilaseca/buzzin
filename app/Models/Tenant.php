<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Tenant extends Model
{
    use HasFactory;

    protected $fillable = [
        'cnpj', 'plan_id', 'name', 'uid', 'url', 'email', 'logo',
        'address', 'zip_code', 'state', 'city', 'district', 'number',
        'active', 'subscription', 'expires_at', 'subscription_id', 'subscription_active', 'subscription_suspended',
        'order_when_closed', 'open', 'mobile_phone', 'data'
    ];


    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function site()
    {
        return $this->hasMany(Site::class, 'tenant_id', 'id');
    }

    public function tenantShipping()
    {
        return $this->hasMany(TenantShipping::class, 'tenant_id', 'id');
    }

    public function tenantPaymentMethods()
    {
        return $this->hasMany(TenantPayment::class, 'tenant_id', 'id');
    }

    public function operatioDay()
    {
        return $this->hasMany(TenantOperationDay::class, 'tenant_id', 'id');
    }

    public function clientCanBay()
    {
        $isOpen = $this->isOpen();
        if ($isOpen == 'N' && !$this->order_when_closed) {
            return 'N';
        }

        return 'Y';
    }

    public function getGetOperationDays()
    {
        $operationDays = $this->operatioDay()
            ->select('tenant_operation_days.*', 'operation_days.description')
            ->join('operation_days', 'tenant_operation_days.operation_day_id', '=', 'operation_days.id')
            ->where('status', 1)->get();

        if (sizeof($operationDays) > 0) {
            foreach ($operationDays as $key => $day) {
                $operationDays[$key]->time = DB::table('tenant_operation_day_times')->select(
                    DB::raw("TIME_FORMAT(time_ini, '%H-%i') as time_ini, TIME_FORMAT(time_end, '%H-%i') as time_end"),
                )->where(['tenant_operation_day_id' => $day->id, 'tenant_id' => $day->tenant_id])->get();
            }
        }

        return $operationDays;
    }

    public function isOpen()
    {
        $semana = [
            'Sunday' => 'Domingo',
            'Monday' => 'Segunda-Feira',
            'Tuesday' => 'Terca-Feira',
            'Wednesday' => 'Quarta-Feira',
            'Thursday' => 'Quinta-Feira',
            'Friday' => 'Sexta-Feira',
            'Saturday' => 'Sábado'
        ];

        $day = $semana[Carbon::now()->format('l')];

        $operationDays = $this->operatioDay()
            ->join('operation_days', 'tenant_operation_days.operation_day_id', '=', 'operation_days.id')
            ->where('status', 1)->get();

        //se não tiver habilitado nem um dia de funcionamento a loja ta fechada
        if ($operationDays->isEmpty()) {
            return 'N';
        }

        //verifica se hj ta funcionando
        $worksToday = $operationDays->where('description', $day)->first();
        if (!$worksToday) {
            return 'N';
        }

        //caso hoje funcione mas a loja está fechada
        if ($worksToday && $this->open == 'N') {
            return 'N';
        }

        return 'Y';
    }

    public function getSocial()
    {
        $data = json_decode($this->data);
        $item['facebook'] = @$data?->social?->facebook;
        $item['instagram'] = @$data?->social?->instagram;
        $item['youtube'] = @$data?->social?->youtube;
        return $item;
    }

    public function getAboutUs()
    {
        $data = json_decode($this->data);
        return @$data?->about_us;
    }
}

<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\OperationDay;
use App\Models\Tenant;
use App\Models\TenantOperationDay;
use App\Models\TenantOperationDayTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class OperationController extends Controller
{
    private $tenantOperation;
    private $operationDays;
    private $tenant;
    private $tenantOperationDayTime;

    public function __construct(TenantOperationDay $tenantOperation, OperationDay $operationDays, Tenant $tenant, TenantOperationDayTime $tenantOperationDayTime)
    {
        $this->tenantOperation = $tenantOperation;
        $this->operationDays = $operationDays;
        $this->tenant = $tenant;
        $this->tenantOperationDayTime = $tenantOperationDayTime;

        $this->middleware(['can:tenant_operation']);
    }

    public function index()
    {
        $data['title']              = 'Funcionamento';
        $data['_configuration']     = true;
        $data['_operation']         = true;
        $data['operationDays']      = $this->operationDays->get();
        $data['tenantOperations']    = $this->tenantOperation->get();
        $data['tenant'] = $this->tenant->find(Auth::user()->tenant_id);

        return view('admin.configuration.operation', $data);
    }

    public function detailOperation($id)
    {
        $operation = $this->tenantOperation->find($id);
        if (!$operation) {
            return Redirect::back()->with('warning', 'Operação não autorizada');
        }

        $dayOperation = $this->operationDays->find($operation->operation_day_id);

        $data['title']                      = 'Funcionamento';
        $data['_configuration']             = true;
        $data['_operation']                 = true;
        $data['breadcrumb_config'][]        = ['route' => route('admin.operations'), 'title' => 'Funcionamento'];
        $data['breadcrumb_config'][]        = ['route' => '#', 'title' => 'Detalhes Funcionamento ' . $dayOperation->description, 'active' => true];
        $data['list']                       = $this->tenantOperationDayTime->where('tenant_operation_day_id', $id)->get();
        $data['tenantOperation']            = $operation;
        return view('admin.configuration.operation_detail', $data);
    }

    public function active(Request $request)
    {
        if (!$request->operation_day_id) {
            return Redirect::back()->with('error', 'Operação não autorizada');
        }

        $dayOperationExists = $this->operationDays->find($request->operation_day_id);
        if (!$dayOperationExists) {
            return Redirect::back()->with('error', 'Operação não autorizada');
        }

        $hasOperationDay = $this->tenantOperation->where('operation_day_id', $request->operation_day_id)->first();
        if ($hasOperationDay) {
            return Redirect::back()->with('error', 'Operação não autorizada');
        }

        $res = $this->tenantOperation->create([
            'operation_day_id' => $request->operation_day_id,
            'status' => 1
        ]);

        if (!$res) {
            return Redirect::back()->with('error', 'Erro ao habilitar a forma de pagamento');
        }

        return Redirect::route('admin.operations')->with('success', "Dia de operação habilitado com sucesso");
    }

    public function disable(Request $request, $id)
    {
        $tenantOperation = $this->tenantOperation->find($id);
        if (!$tenantOperation) {
            return Redirect::back()->with('error', 'Operação não autorizada');
        }

        $tenantOperation->update(['status' => 0]);

        return Redirect::route('admin.operations')->with('success', "Dia de operação desabilitado com sucesso");
    }

    public function enable(Request $request, $id)
    {
        $tenantOperation = $this->tenantOperation->find($id);
        if (!$tenantOperation) {
            return Redirect::back()->with('error', 'Operação não autorizada');
        }

        $tenantOperation->update(['status' => 1]);

        return Redirect::route('admin.operations')->with('success', "Dia de operação habilitado com sucesso");
    }

    public function detailStore(Request $request, $id) {
        $validate = Validator::make($request->all(), [
            'time_ini'      => ['required'],
            'time_end'      => ['required'],
        ]);

        if ($validate->fails()) {
            return Redirect::back()->with('error', $validate->errors());
        }

        $exist = $this->tenantOperation->find($id);
        if(!$exist) {
            return Redirect::back()->with('error', 'Operação não autorizada');
        }

        if(strtotime($request->time_ini) == strtotime($request->time_end)){
            return Redirect::back()->with('warning', 'A hora inicial não pode ser igual a hora final');
        }

        if(strtotime($request->time_ini) > strtotime($request->time_end)){
            return Redirect::back()->with('warning', 'O horário final não deve ser maior que o horário inicial');
        }

        $res = $this->tenantOperationDayTime->create([
            'tenant_operation_day_id' => $id,
            'time_ini' => $request->time_ini,
            'time_end' => $request->time_end
        ]);

        if(!$res) {
            return Redirect::back()->with('error', 'Falha na operação');
        }

        return Redirect::back()->with('success', 'Horário cadastrado com sucesso');
    }

    public function detailDelete(Request $request, $id) {
        $validate = Validator::make($request->all(), [
            'operation_day_id'      => ['required'],
        ]);

        if ($validate->fails()) {
            return Redirect::back()->with('error', $validate->errors());
        }

        $exist = $this->tenantOperation->find($id);
        if(!$exist) {
            return Redirect::back()->with('error', 'Operação não autorizada');
        }

        $exist = $this->tenantOperationDayTime->find($request->operation_day_id);
        if(!$exist) {
            return Redirect::back()->with('error', 'Operação não autorizada');
        }

        $exist->delete();

        return Redirect::back()->with('success', 'Registro apagado com sucesso');
    }
}

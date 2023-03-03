<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateTenant;
use App\Models\Plan;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TenantController extends Controller
{
    private $repository;
    private $plans;
    private $superAdmin;

    public function __construct(
        Tenant $produtc,
        Plan $plans
    ) {
        $this->repository = $produtc;
        $this->plans = $plans;

        $this->middleware(['can:tenants']);

        $this->middleware(function ($request, $next) {
            $this->superAdmin = Auth()->user()->isAdmin();
            return $next($request);
        });
    }

    public function index()
    {
        $data['title']              = 'Empresas';
        $data['toptitle']           = 'Empresas';
        $data['breadcrumb'][]       = ['route' => route('admin.dashboard'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => 'Empresas', 'active' => true];
        $data['ten']                = true;
        $data['tenants']            = $this->repository->latest()->paginate();

        return view('admin.tenants.index', $data);
    }

    public function create()
    {
        $data['title']              = 'Nova empresa';
        $data['toptitle']           = 'Nova empresa';
        $data['breadcrumb'][]       = ['route' => route('admin.dashboard'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => route('admin.tenants'), 'title' => 'Empresas'];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => 'Nova empresa', 'active' => true];
        $data['plans'] = $this->plans->all();
        $data['ten']               = true;

        return view('admin.tenants.create', $data);
    }

    public function search(Request $request)
    {
        $data['title']              = 'Empresas';
        $data['toptitle']           = 'Empresas';
        $data['breadcrumb'][]       = ['route' => route('admin.dashboard'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => 'Empresas', 'active' => true];;
        $data['ten']               = true;
        $data['tenants']         = $this->repository->search($request->filter);
        $data['filters']            = $request->except('_token');

        return view('admin.tenants.index', $data);
    }

    public function edit($id)
    {
        $tenant = $this->repository->find($id);
        if (!$tenant)
            return Redirect::route('admin.tenants')->with('warning', 'Operação não autorizada');

        $data['title']              = 'Editar empresa ' . $tenant->name;
        $data['toptitle']           = 'Editar empresa ' . $tenant->name;
        $data['breadcrumb'][]       = ['route' => route('admin.dashboard'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => route('admin.tenants'), 'title' => 'Empresas'];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => 'Editar empresa ' . $tenant->name, 'active' => true];
        $data['plans'] = $this->plans->all();
        $data['ten']               = true;
        $data['tenant'] = $tenant;

        return view('admin.tenants.edit', $data);
    }


    public function show($id)
    {
        $tenant = $this->repository->find($id);
        if (!$tenant)
            return Redirect::route('admin.tenants')->with('warning', 'Operação não autorizada');

        $data['title']              = 'Empresa ' . $tenant->name;
        $data['toptitle']           = 'Empresa ' . $tenant->name;
        $data['breadcrumb'][]       = ['route' => route('admin.dashboard'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => route('admin.tenants'), 'title' => 'Empresa'];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => 'Empresa ' . $tenant->name, 'active' => true];
        $data['ten']               = true;
        $data['tenant'] = $tenant;

        return view('admin.tenants.show', $data);
    }

    public function store(StoreUpdateTenant $request)
    {
        $data = $request->all();
        $tenant = auth()->user()->tenant;

        $exist = $this->repository->where('name', '=', $request->name)->first();
        if ($exist)
            return Redirect::back()->with('warning', 'Já existe uma empresa com esse nome');

        if ($request->hasFile('logo') && $request->logo->isValid())
            $data['logo'] = $request->logo->store("public/tenants/{$tenant->uuid}/logo");

        $this->repository->create($data);

        return Redirect::route('admin.tenants')->with('success', 'Empresa criado com sucesso');
    }

    public function update(StoreUpdateTenant $request, $id)
    {
        $tenant = $this->repository->find($id);
        if (!$tenant)
            return Redirect::back()->with('error', 'Operação não autorizada');

        $except[] = '_token';
        $except[] = '_method';

        if ($tenant->name !== $request->name) {
            $exist = $this->repository->where('name', '=', $request->name)->first();
            if ($exist)
                return Redirect::back()->with('warning', 'Já existe uma empresa com esse nome');
        } else {
            $except[] = 'name';
        }

        if ($tenant->email !== $request->email) {
            $exist = $this->repository->where('email', '=', $request->email)->first();
            if ($exist)
                return Redirect::back()->with('warning', 'Já existe uma empresa com essas credenciais');
        } else {
            $except[] = 'email';
        }


        if ($tenant->cnpj !== $request->cnpj) {
            $exist = $this->repository->where('cnpj', '=', $request->cnpj)->first();
            if ($exist)
                return Redirect::back()->with('warning', 'Já existe uma empresa com essas credenciais');
        } else {
            $except[] = 'cnpj';
        }

        $request->except('_token');
        $data = $request->except($except);

        if ($request->hasFile('logo') && $request->logo->isValid()) {
            if (Storage::exists($tenant->logo)) {
                Storage::delete($tenant->logo);
            }

            $data['logo'] = $request->logo->store("public/tenants/{$tenant->uuid}/logo");
        }

        Tenant::where([
            'id' => $tenant->id,
        ])->update($data);

        return Redirect::route('admin.tenants')->with('success', 'Empresa editado com sucesso');
    }

    public function destroy($id)
    {
        if (!$this->superAdmin) return Redirect::back()->with('error', 'Operação não autorizada');

        $tenant = $this->repository->find($id);

        if (!$tenant) return Redirect::back()->with('error', 'Operação não autorizada');

        DB::beginTransaction();
        try {

            if (Storage::exists($tenant->image)) Storage::delete($tenant->image);

            $tenant_user = User::where('tenant_id', $tenant->id)->get();
            if ($tenant_user)  User::where('tenant_id', $tenant->id)->delete();

            $this->repository->where('id', $tenant->id)->delete();
            DB::commit();
            return Redirect::route('admin.tenants')->with('success', 'Empresa apagada com sucesso');
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return Redirect::route('admin.tenants')->with('error', 'Houve um erro ao apagar a empresa');
        }

        $tenant->delete();
        return Redirect::route('admin.tenants')->with('success', 'Empresa removido com sucesso');
    }

    public function orderWhenClosed(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'order_when_closed'      => ['required', 'integer'],
        ]);

        if ($validate->fails()) {
            return Redirect::back()->with('error', $validate->errors());
        }

        $res = $this->repository
            ->where('id', Auth::user()->tenant_id)
            ->update(['order_when_closed' => $request->order_when_closed]);
        if (!$res) {
            return Redirect::back()->with('warning', 'Erro na operação');
        }

        return Redirect::back()->with('success', 'Operação realizada com sucesso');
    }

    public function open(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'open'      => ['required'],
        ]);

        if ($validate->fails()) {
            return Redirect::back()->with('error', $validate->errors());
        }

        $res = $this->repository
            ->where('id', Auth::user()->tenant_id)
            ->update(['open' => $request->open]);
        if (!$res) {
            return Redirect::back()->with('warning', 'Erro na operação');
        }

        return Redirect::back()->with('success', 'Operação realizada com sucesso');
    }
}

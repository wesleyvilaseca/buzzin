<?php

namespace App\Http\Controllers\Admin\ACL;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateRole;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class RoleController extends Controller
{
    protected $repository;

    public function __construct(
        Role $role
    ) {
        $this->repository = $role;
        $this->middleware(['can:roles']);
    }

    public function index()
    {
        $data['title']              = 'Cargos';
        $data['toptitle']           = 'Cargos';
        $data['breadcrumb'][]       = ['route' => route('admin.dashboard'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => 'Cargos', 'active' => true];
        $data['roles']        =  $this->repository->latest()->paginate();
        $data['perm']               = true;
        $data['rol']              = true;

        return view('admin.roles.index', $data);
    }

    public function create()
    {
        $data['title']              = 'Criar cargo';
        $data['toptitle']           = 'Criar cargo';
        $data['breadcrumb'][]       = ['route' => route('admin.dashboard'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => route('admin.roles'), 'title' => 'Cargos'];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => 'Criar cargo', 'active' => true];
        $data['perm']               = true;
        $data['rol']              = true;

        return view('admin.roles.create', $data);
    }

    public function edit(int $role_id)
    {
        $role = $this->repository->find($role_id);
        if (!$role)
            return Redirect::back()->with('warning', 'Operação não autorizada');

        $data['title']              = 'Editar Cargo ' . $role->name;
        $data['toptitle']           = 'Editar Cargo ' . $role->name;
        $data['breadcrumb'][]       = ['route' => route('admin.dashboard'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => route('admin.roles'), 'title' => 'Cargos'];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => 'Editar Cargo ' . $role->name, 'active' => true];
        $data['role']               = $role;
        $data['perm']               = true;
        $data['rol']              = true;

        return view('admin.roles.edit', $data);
    }

    public function show($role_id)
    {
        $role = $this->repository->find($role_id);
        if (!$role)
            return Redirect::back()->with('warning', 'Operação não autorizada');

        $data['title']              = 'Cargo ' . $role->name;
        $data['toptitle']           = 'Cargo ' . $role->name;
        $data['breadcrumb'][]       = ['route' => route('admin.dashboard'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => route('admin.roles'), 'title' => 'Cargos'];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => 'Cargo ' . $role->name, 'active' => true];
        $data['role']         = $role;
        $data['perm']               = true;
        $data['rol']              = true;

        return view('admin.roles.show', $data);
    }

    public function store(StoreUpdateRole $request)
    {
        $result = $this->repository->create($request->all());
        if (!$result)
            return Redirect::back()->with('warning', 'Erro na operação');

        return Redirect::route('admin.roles')->with('success', 'Cargo criada com sucesso');
    }

    public function update(StoreUpdaterole $request, $role_id)
    {
        $role = $this->repository->find($role_id);
        if (!$role)
            return Redirect::back()->with('warning', 'Operação não autorizada');

        $result = $role->update($request->all());

        if (!$result)
            return Redirect::back()->with('warning', 'Erro na operação');

        return Redirect::route('admin.roles')->with('success', 'Cargo editada com sucesso');
    }

    public function destroy($role_id)
    {
        $role = $this->repository->find($role_id);
        if (!$role)
            return Redirect::back()->with('warning', 'Operação não autorizada');

        $result = $role->delete();
        if (!$result)
            return Redirect::back()->with('warning', 'Erro na operação');

        return Redirect::route('admin.roles')->with('success', 'Cargo removido com sucesso');
    }
}

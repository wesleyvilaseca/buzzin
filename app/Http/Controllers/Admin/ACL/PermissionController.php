<?php

namespace App\Http\Controllers\Admin\ACL;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdatePermission;
use Illuminate\Http\Request;
use App\Models\Permission;
use Illuminate\Support\Facades\Redirect;

class PermissionController extends Controller
{
    protected $repository;

    public function __construct(
        Permission $permission
    ) {
        $this->repository = $permission;
        $this->middleware(['can:permissions']);
    }

    public function index()
    {
        $data['title']              = 'Permissões';
        $data['toptitle']           = 'Permissões';
        $data['breadcrumb'][]       = ['route' => route('admin.dashboard'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => 'Permissões', 'active' => true];
        $data['permissions']        =  $this->repository->latest()->paginate();
        $data['perm']               = true;
        $data['permi']              = true;

        return view('admin.permissions.index', $data);
    }

    public function create()
    {
        $data['title']              = 'Criar permissão';
        $data['toptitle']           = 'Criar permissão';
        $data['breadcrumb'][]       = ['route' => route('admin.dashboard'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => 'Criar permissão', 'active' => true];
        $data['perm']               = true;
        $data['permi']              = true;

        return view('admin.permissions.create', $data);
    }

    public function edit(int $permission_id)
    {
        $permission = $this->repository->find($permission_id);
        if (!$permission)
            return Redirect::back()->with('warning', 'Operação não autorizada');

        $data['title']              = 'Editar permissão ' . $permission->name;
        $data['toptitle']           = 'Editar permissão ' . $permission->name;
        $data['breadcrumb'][]       = ['route' => route('admin.dashboard'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => route('admin.permissions'), 'title' => 'Permissões'];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => 'Editar permissão ' . $permission->name, 'active' => true];
        $data['permission']         = $permission;
        $data['perm']               = true;
        $data['permi']              = true;

        return view('admin.permissions.edit', $data);
    }

    public function show($permission_id)
    {
        $permission = $this->repository->find($permission_id);
        if (!$permission)
            return Redirect::back()->with('warning', 'Operação não autorizada');

        $data['title']              = 'Permissão ' . $permission->name;
        $data['toptitle']           = 'Permissão ' . $permission->name;
        $data['breadcrumb'][]       = ['route' => route('admin.dashboard'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => route('admin.permissions'), 'title' => 'Permissões'];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => 'Permissão ' . $permission->name, 'active' => true];
        $data['permission']         = $permission;
        $data['perm']               = true;
        $data['permi']              = true;

        return view('admin.permissions.show', $data);
    }

    public function store(StoreUpdatePermission $request)
    {
        $result = $this->repository->create($request->all());
        if (!$result)
            return Redirect::back()->with('warning', 'Erro na operação');

        return Redirect::route('admin.permissions')->with('success', 'Permissão criada com sucesso');
    }

    public function update(StoreUpdatePermission $request, $permission_id)
    {
        $permission = $this->repository->find($permission_id);
        if (!$permission)
            return Redirect::back()->with('warning', 'Operação não autorizada');

        $result = $permission->update($request->all());

        if (!$result)
            return Redirect::back()->with('warning', 'Erro na operação');

        return Redirect::route('admin.permissions')->with('success', 'Permissão editada com sucesso');
    }

    public function destroy($permission_id)
    {
        $permission = $this->repository->find($permission_id);
        if (!$permission)
            return Redirect::back()->with('warning', 'Operação não autorizada');

        $result = $permission->delete();
        if (!$result)
            return Redirect::back()->with('warning', 'Erro na operação');

        return Redirect::route('admin.permissions')->with('success', 'Permissão removido com sucesso');
    }
}

<?php

namespace App\Http\Controllers\Web\Admin\ACL;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class PermissionRoleController extends Controller
{
    protected $role, $permission;

    public function __construct(Role $role, Permission $permission)
    {
        $this->role = $role;
        $this->permission = $permission;

        $this->middleware(['can:roles']);
    }

    public function permissions($role_id)
    {
        $role = $this->role->find($role_id);
        if (!$role)
            return Redirect::back()->with('error', 'Operação não autorizada');

        $data['role']            = $role;
        $data['permissions']        =  $role->permissions()->paginate();
        $data['title']              = 'Permissões do cargo ' . $role->name;
        $data['toptitle']           = 'Permissões do cargo ' . $role->name;
        $data['breadcrumb'][]       = ['route' => route('admin.dashboard'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => route('admin.roles'), 'title' => 'Perfis'];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => 'Permissões do cargo ' . $role->name, 'active' => true];
        $data['perm']               = true;
        $data['rol']              = true;

        return view('admin.roles.permissions.index', $data);
    }


    public function roles($idPermission)
    {
        if (!$permission = $this->permission->find($idPermission)) {
            return Redirect::back();
        }

        $roles = $permission->roles()->paginate();

        return view('admin.roles.permissions.roles', compact('permission', 'roles'));
    }


    public function permissionsAvailable(Request $request, $role_id)
    {
        if (!$role = $this->role->find($role_id)) {
            return Redirect::back();
        }

        $data['role']               = $role;
        $data['permissions']        =  $role->permissionsAvailable($request->filter);
        $data['filter']             = $request->except('_token');
        $data['title']              = 'Permissões do cargo ' . $role->name;
        $data['toptitle']           = 'Permissões do cargo ' . $role->name;
        $data['breadcrumb'][]       = ['route' => route('admin.dashboard'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => route('admin.roles'), 'title' => 'Perfis'];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => 'Permissões do cargo ' . $role->name, 'active' => true];
        $data['perm']               = true;
        $data['rol']                = true;

        return view('admin.roles.permissions.available', $data);
    }


    public function attachPermissionsRole(Request $request, $role_id)
    {
        if (!$role = $this->role->find($role_id)) {
            return Redirect::back();
        }

        if (!$request->permissions || count($request->permissions) == 0) {
            return Redirect::back()->with('info', 'Precisa escolher pelo menos uma permissão');
        }

        $role->permissions()->attach($request->permissions);

        return Redirect::route('roles.permissions', $role->id);
    }

    public function detachPermissionRole($role_id, $idPermission)
    {
        $role = $this->role->find($role_id);
        $permission = $this->permission->find($idPermission);

        if (!$role || !$permission) {
            return Redirect::back();
        }

        $role->permissions()->detach($permission);

        return Redirect::route('roles.permissions', $role->id);
    }
}

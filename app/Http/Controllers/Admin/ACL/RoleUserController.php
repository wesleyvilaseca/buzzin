<?php

namespace App\Http\Controllers\Admin\ACL;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\User as ModelsUser;
use Illuminate\Support\Facades\Redirect;

class RoleUserController extends Controller
{
    protected $user;
    protected $role;

    public function __construct(ModelsUser $user, Role $role)
    {
        $this->user = $user;
        $this->role = $role;
    }

    public function roles($user_id)
    {
        $user = $this->user->tenantUser()->find($user_id);
        if (!$user)
            return Redirect::back()->with('error', 'Operação não autorizada');

        $data['title']              = 'Permissões do usuário ' . $user->name;
        $data['toptitle']           = 'Permissões do usuário ' . $user->name;
        $data['breadcrumb'][]       = ['route' => route('admin.dashboard'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => 'Permissões do usuário ' . $user->name, 'active' => true];
        $data['us'] = true;
        $data['user'] = $user;
        $data['roles'] = $user->roles()->paginate();

        return view('admin.user_roles.index', $data);
    }

    public function rolesAvailable(Request $request, $user_id)
    {
        $user = $this->user->tenantUser()->find($user_id);
        if (!$user)
            return Redirect::back()->with('error', 'Operação não autorizada');

        $data['title']              = 'Editar permissões do usuário ' . $user->name;
        $data['toptitle']           = 'Editar permissões do usuário ' . $user->name;
        $data['breadcrumb'][]       = ['route' => route('admin.dashboard'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => route('users.roles', $user->id), 'title' => 'Permissões do usuário ' . $user->name];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => 'Editar permissões do usuário ' . $user->name, 'active' => true];
        $data['user'] = $user;
        $data['filters'] = $request->except('_token');
        $data['roles'] = $user->rolesAvailable($request->filter);

        return view('admin.user_roles.avaliable', $data);
    }


    public function users($idRole)
    {
        if (!$role = $this->role->find($idRole)) {
            return redirect()->back();
        }

        $users = $role->users()->paginate();

        return view('admin.pages.roles.users.users', compact('role', 'users'));
    }

    public function attachRolesUser(Request $request, $idUser)
    {
        if (!$user = $this->user->find($idUser)) {
            return redirect()->back();
        }

        if (!$request->roles || count($request->roles) == 0) {
            return redirect()
                ->back()
                ->with('info', 'Precisa escolher pelo menos uma permissão');
        }

        $user->roles()->attach($request->roles);

        return redirect()->route('users.roles', $user->id);
    }

    public function detachRoleUser($idUser, $idRole)
    {
        $user = $this->user->find($idUser);
        $role = $this->role->find($idRole);

        if (!$user || !$role) {
            return redirect()->back();
        }

        $user->roles()->detach($role);

        return redirect()->route('users.roles', $user->id);
    }
}

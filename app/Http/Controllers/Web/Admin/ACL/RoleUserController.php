<?php

namespace App\Http\Controllers\Web\Admin\ACL;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\User as ModelsUser;
use Illuminate\Support\Facades\Redirect;

class RoleUserController extends Controller
{
    protected $user;
    protected $role;
    protected $superAdmin;
    protected $userRepository;

    public function __construct(ModelsUser $userRepository, Role $role)
    {
        $this->middleware(['can:user']);
        $this->userRepository = $userRepository;
        $this->role = $role;

        $this->middleware(function ($request, $next) {
            $this->superAdmin = Auth()->user()->isAdmin();

            if ($request->id) {
                $this->user = $this->superAdmin ? $this->userRepository->find($request->id) : $this->userRepository->tenantUser()->find($request->id);
                if (!$this->user) {
                    return Redirect::back()->with('error', 'Operação não autorizada');
                }
            }
            return $next($request);
        });
    }

    public function roles()
    {
        $data['title']              = 'Permissões do usuário ' . $this->user->name;
        $data['toptitle']           = 'Permissões do usuário ' . $this->user->name;
        $data['breadcrumb'][]       = ['route' => route('admin.dashboard'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => 'Permissões do usuário ' . $this->user->name, 'active' => true];
        $data['us'] = true;
        $data['user'] = $this->user;
        $data['roles'] = $this->user->roles()->paginate();

        return view('admin.user_roles.index', $data);
    }

    public function rolesAvailable(Request $request)
    {
        $roles = $this->user->rolesAvailable($request->filter);

        if(!$this->superAdmin){
            foreach ($roles as $key => $role) {
                if ($role->internal) {
                    unset($roles[$key]);
                }
            }
        }

        $data['title']              = 'Editar permissões do usuário ' . $this->user->name;
        $data['toptitle']           = 'Editar permissões do usuário ' . $this->user->name;
        $data['breadcrumb'][]       = ['route' => route('admin.dashboard'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => route('users.roles', $this->user->id), 'title' => 'Permissões do usuário ' . $this->user->name];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => 'Editar permissões do usuário ' . $this->user->name, 'active' => true];
        $data['user'] = $this->user;
        $data['filters'] = $request->except('_token');
        $data['roles'] = $roles;

        return view('admin.user_roles.avaliable', $data);
    }


    public function users(Request $request)
    {
        if (!$role = $this->role->find($request->idRole)) return redirect()->back();
        $users = $role->users()->paginate();
        return view('admin.pages.roles.users.users', compact('role', 'users'));
    }

    public function attachRolesUser(Request $request)
    {
        if (!$request->roles || count($request->roles) == 0) {
            return redirect()
                ->back()
                ->with('info', 'Precisa escolher pelo menos uma permissão');
        }

        $this->user->roles()->attach($request->roles);

        return redirect()->route('users.roles', $this->user->id);
    }

    public function detachRoleUser(Request $request)
    {
        $role = $this->role->find($request->idRole);

        if (!$role) return redirect()->back();

        $this->user->roles()->detach($role);

        return redirect()->route('users.roles', $this->user->id);
    }
}

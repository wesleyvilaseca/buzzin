<?php

namespace App\Http\Controllers\Web\Admin\ACL;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class PermissionProfileController extends Controller
{
    protected $profile;
    protected $permission;

    public function __construct(
        Profile $profile,
        Permission $permission
    ) {
        $this->middleware(['can:acl']);
        $this->profile          = $profile;
        $this->permission       = $permission;
    }

    public function permissions($profile_id)
    {
        $profile = $this->profile->find($profile_id);
        if (!$profile)
            return Redirect::back()->with('error', 'Operação não autorizada');

        $data['profile']            = $profile;
        $data['permissions']        =  $profile->permissions()->get();
        $data['title']              = 'Permissões do perfil ' . $profile->name;
        $data['toptitle']           = 'Permissões do perfil ' . $profile->name;
        $data['breadcrumb'][]       = ['route' => route('admin.dashboard'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => route('admin.profiles'), 'title' => 'Perfis'];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => 'Permissões do perfil ' . $profile->name, 'active' => true];
        $data['prof']               = true;

        return view('admin.profiles.permissions', $data);
    }

    public function permissionsAvailable(Request $request, $profile_id)
    {
        $profile = $this->profile->find($profile_id);
        if (!$profile)
            return Redirect::back()->with('error', 'Operação não autorizada');

        $data['filters']            = $request->except('_token');
        $data['profile']            = $profile;
        $data['permissions']        = $profile->permissionsAvailable($request->filter);
        $data['title']              = 'Nova permissão do perfil ' . $profile->name;
        $data['toptitle']           = 'Nova permissão do perfil ' . $profile->name;
        $data['breadcrumb'][]       = ['route' => route('admin.dashboard'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => route('admin.profiles'), 'title' => 'Perfis'];
        $data['breadcrumb'][]       = ['route' => route('profile.permissions', $profile->id), 'title' => 'Permissões perfil ' . $profile->name];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => 'Nova permissão do perfil ' . $profile->name, 'active' => true];
        $data['prof']               = true;

        return view('admin.profiles.available', $data);
    }

    public function attachPermissionsProfile(Request $request, $profile_id)
    {
        $profile = $this->profile->find($profile_id);
        if (!$profile)
            return Redirect::back()->with('error', 'Operação não autorizada');

        if (!$request->permissions || count($request->permissions) == 0) {
            return Redirect::back()->with('warning', 'Precisa escolher pelo menos uma permissão');
        }

        $profile->permissions()->attach($request->permissions);

        return Redirect::route('profile.permissions', $profile->id)->with('success', 'Operação efetuada com sucesso');
    }

    public function detachPermissionProfile($profile_id, $permission_id)
    {
        $profile    = $this->profile->find($profile_id);
        $permission = $this->permission->find($permission_id);

        if (!$profile || !$permission)
            return Redirect::back()->with('error', 'Operação não autorizada');

        $profile->permissions()->detach($permission);

        return Redirect::route('profile.permissions', $profile->id)->with('success', 'Operação efetuada com sucesso');
    }

    public function profiles($permission_id)
    {
        $permission = $this->permission->find($permission_id);
        if (!$permission)
            return Redirect::back()->with('error', 'Operação não autorizada');

        $data['permission']         = $permission;
        $data['profiles']           = $permission->profiles()->paginate();
        $data['title']              = 'Perfis da permissão ' . $permission->name;
        $data['toptitle']           = 'Perfis da permissão ' . $permission->name;
        $data['breadcrumb'][]       = ['route' => route('admin.dashboard'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => route('admin.permissions'), 'title' => 'Permissões'];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => 'Perfis da permissão ' . $permission->name, 'active' => true];
        $data['perm']               = true;
        $data['permi']              = true;


        return view('admin.permissions.profiles', $data);
    }
}

<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateUser;
use App\Models\User as ModelsUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    protected $repository;

    public function __construct(ModelsUser $user)
    {
        $this->repository = $user;

        $this->middleware(['can:user']);
    }

    public function index()
    {
        $data['title']              = 'Usuários';
        $data['toptitle']           = 'Usuários';
        $data['breadcrumb'][]       = ['route' => route('admin.dashboard'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => 'Usuários', 'active' => true];
        $data['users']            = $this->repository->latest()->tenantUser()->paginate();
        $data['us']               = true;

        return view('admin.user.index', $data);
    }

    public function search(Request $request)
    {
        $data['title']              = 'Usuários';
        $data['toptitle']           = 'Usuários';
        $data['breadcrumb'][]       = ['route' => route('admin.dashboard'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => 'Usuários', 'active' => true];
        $data['users']              =  $this->repository->search($request->filter);
        $data['filters']              = $request->except('_token');
        $data['us']               = true;

        return view('admin.user.index', $data);
    }

    public function create()
    {
        $data['title']              = 'Novo usuário';
        $data['toptitle']           = 'Novo usuário';
        $data['breadcrumb'][]       = ['route' => route('admin.dashboard'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => 'Novo usuário', 'active' => true];
        $data['us']               = true;

        return view('admin.user.create', $data);
    }

    public function edit($id)
    {
        $user = $this->repository->tenantUser()->find($id);
        if (!$user)
            return Redirect::back()->with('error', 'Operação não autorizada');

        $data['title']              = 'Editar usuário ' . $user->name;
        $data['toptitle']           = 'Editar usuário ' . $user->name;
        $data['breadcrumb'][]       = ['route' => route('admin.dashboard'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => 'Editar usuário ' . $user->name, 'active' => true];
        $data['us']               = true;
        $data['user']             = $user;

        return view('admin.user.edit', $data);
    }

    public function show($id)
    {
        $user = $this->repository->tenantUser()->find($id);
        if (!$user)
            return Redirect::back()->with('error', 'Operação não autorizada');

        $data['title']              = 'Usuário ' . $user->name;
        $data['toptitle']           = 'Usuário ' . $user->name;
        $data['breadcrumb'][]       = ['route' => route('admin.users'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => 'Usuário ' . $user->name, 'active' => true];
        $data['us']               = true;
        $data['user']             = $user;

        return view('admin.user.show', $data);
    }

    public function store(StoreUpdateUser $request)
    {
        $exist = $this->repository->where('email', $request->email)->first();
        if ($exist)
            return Redirect::back()->with('warning', 'Já existe um usuário com as credênciais informadas');

        $data = $request->all();
        $data['tenant_id'] = auth()->user()->tenant_id;
        $data['password'] = bcrypt($data['password']); // encrypt password

        $result = $this->repository->create($data);
        if (!$result)
            return Redirect::back()->with('warning', 'Erro na operação');

        return Redirect::route('admin.users')->with('success', 'Usuário criado com sucesso');
    }

    public function update(StoreUpdateUser $request, $id)
    {
        $user = $this->repository->tenantUser()->find($id);
        if (!$user)
            return Redirect::back()->with('error', 'Operação não autorizada');

        if ($request->email !== $user->email) {
            $exist = $this->repository->where('email', $request->email)->first();
            if ($exist)
                return Redirect::back()->with('warning', 'Já existe um usuário com essas credênciais');
        }

        $data = $request->only(['name', 'email']);

        if ($request->password)
            $data['password'] = bcrypt($request->password);

        $user->update($data);

        return Redirect::route('admin.users')->with('success', 'Usuário editado com sucesso');
    }

    public function destroy($id)
    {
        $user = $this->repository->tenantUser()->find($id);
        if (!$user)
            return Redirect::back()->with('error', 'Operação não autorizada');

        $user->delete();

        return Redirect::route('admin.users')->with('success', 'Usuário removido com sucesso');
    }
}

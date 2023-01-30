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
    protected $superAdmin;
    private $user;


    public function __construct(ModelsUser $user)
    {
        $this->repository = $user;

        $this->middleware(['can:user']);

        $this->middleware(function ($request, $next) {
            $this->superAdmin = Auth()->user()->isAdmin();

            if ($request->id) {
                $this->user = $this->superAdmin ? $this->repository->find($request->id) : $this->repository->tenantUser()->find($request->id);
                if (!$this->user) {
                    return Redirect::back()->with('error', 'Operação não autorizada');
                }
            }
            return $next($request);
        });
    }

    public function index()
    {
        $users = $this->superAdmin ? $this->repository->latest()->paginate() : $this->repository->latest()->tenantUser()->paginate();

        $data['title']              = 'Usuários';
        $data['toptitle']           = 'Usuários';
        $data['breadcrumb'][]       = ['route' => route('admin.dashboard'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => 'Usuários', 'active' => true];
        $data['users']            = $users;
        $data['superAdmin']       = $this->superAdmin;
        $data['us']               = true;

        return view('admin.user.index', $data);
    }

    public function search(Request $request)
    {
        $users = $this->superAdmin ? $this->repository->searchAll($request->filter) : $this->repository->search($request->filter);
        $data['title']              = 'Usuários';
        $data['toptitle']           = 'Usuários';
        $data['breadcrumb'][]       = ['route' => route('admin.dashboard'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => 'Usuários', 'active' => true];
        $data['users']              = $users;
        $data['filters']            = $request->except('_token');
        $data['superAdmin']       = $this->superAdmin;
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
        $data['title']              = 'Editar usuário ' . $this->user->name;
        $data['toptitle']           = 'Editar usuário ' . $this->user->name;
        $data['breadcrumb'][]       = ['route' => route('admin.dashboard'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => 'Editar usuário ' . $this->user->name, 'active' => true];
        $data['us']               = true;
        $data['user']             = $this->user;

        return view('admin.user.edit', $data);
    }

    public function show($id)
    {
        $data['title']              = 'Usuário ' . $this->user->name;
        $data['toptitle']           = 'Usuário ' . $this->user->name;
        $data['breadcrumb'][]       = ['route' => route('admin.users'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => 'Usuário ' . $this->user->name, 'active' => true];
        $data['us']               = true;
        $data['user']             = $this->user;

        return view('admin.user.show', $data);
    }

    public function store(StoreUpdateUser $request)
    {
        $exist = $this->repository->where('email', $request->email)->first();
        if ($exist)
            return Redirect::back()->with('warning', 'Já existe um usuário com as credênciais informadas');

        $data = $request->all();
         /**
         * logic for a superadmin can create for any tenant
         */
        $data['tenant_id'] = $this->superAdmin && @$request->tenant_id ? $request->tenant_id : auth()->user()->tenant_id;
        $data['password'] = bcrypt($data['password']); // encrypt password


        $result = $this->repository->create($data);
        if (!$result)
            return Redirect::back()->with('warning', 'Erro na operação');

        return Redirect::route('admin.users')->with('success', 'Usuário criado com sucesso');
    }

    public function update(StoreUpdateUser $request, $id)
    {
        if ($request->email !== $this->user->email) {
            $exist = $this->repository->where('email', $request->email)->first();
            if ($exist)
                return Redirect::back()->with('warning', 'Já existe um usuário com essas credênciais');
        }

        $data = $request->only(['name', 'email']);

        if ($request->password)
            $data['password'] = bcrypt($request->password);

        $this->user->update($data);


        return Redirect::route('admin.users')->with('success', 'Usuário editado com sucesso');
    }

    public function destroy($id)
    {
        $this->user->delete();

        return Redirect::route('admin.users')->with('success', 'Usuário removido com sucesso');
    }
}

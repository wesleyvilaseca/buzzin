<?php

namespace App\Http\Controllers\Admin\ACL;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateProfile;
use Illuminate\Http\Request;
use App\Models\Profile;
use Illuminate\Support\Facades\Redirect;

class ProfileController extends Controller
{
    protected $repository;

    public function __construct(
        Profile $profile
    ) {

        $this->repository = $profile;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title']              = 'Perfis';
        $data['toptitle']           = 'Perfis';
        $data['breadcrumb'][]       = ['route' => route('admin.dashboard'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => 'Perfis', 'active' => true];
        $data['profiles']           = $this->repository->latest()->paginate();
        $data['prof']               = true;

        return view('admin.profiles.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title']              = 'Novo perfil';
        $data['toptitle']           = 'Novo perfil';
        $data['breadcrumb'][]       = ['route' => route('admin.dashboard'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => route('admin.profiles'), 'title' => 'Perfis'];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => 'Novo perfil', 'active' => true];
        $data['profiles']           = $this->repository->latest()->paginate();
        $data['prof']               = true;

        return view('admin.profiles.create', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $profile = $this->repository->find($id);
        if (!$profile)
            return Redirect::back()->with('error', 'Operação não autorizada');

        $data['title']              = 'Editar perfil ' . $profile->name;
        $data['toptitle']           = 'Editar perfil ' . $profile->name;
        $data['breadcrumb'][]       = ['route' => route('admin.dashboard'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => route('admin.profiles'), 'title' => 'Perfis'];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => 'Editar perfil ' . $profile->name, 'active' => true];
        $data['profile']            = $profile;
        $data['prof']               = true;

        return view('admin.profiles.edit', $data);
    }

    public function search(Request $request)
    {
        $data['title']              = 'Perfis';
        $data['toptitle']           = 'Perfis';
        $data['breadcrumb'][]       = ['route' => route('admin.dashboard'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => 'Perfis', 'active' => true];
        $data['plans']              =  $this->repository->search($request->filter);
        $data['profiles']           = $this->repository->search($request->filter);
        $data['prof']               = true;
        $data['filters']            = $request->except('_token');

        return view('admin.profiles.index', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUpdateProfile $request)
    {
        $result = $this->repository->create($request->all());
        if (!$result)
            return Redirect::back()->with('error', 'Erro na operação');

        return Redirect::route('admin.profiles')->with('success', 'Perfil criado com sucesso');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $profile = $this->repository->find($id);
        if (!$profile)
            return Redirect::back()->with('error', 'Operação não autorizada');

        $data['title']              = 'Perfil ' . $profile->name;
        $data['toptitle']           = 'Perfil ' . $profile->name;
        $data['breadcrumb'][]       = ['route' => route('admin.dashboard'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => route('admin.profiles'), 'title' => 'Perfis'];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => 'Perfil ' . $profile->name, 'active' => true];
        $data['profile']            = $profile;
        $data['prof']               = true;

        return view('admin.profiles.show', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUpdateProfile $request, $id)
    {
        $profile = $this->repository->find($id);
        if (!$profile)
            return Redirect::back()->with('error', 'Operação não autorizada');


        $result = $profile->update($request->all());
        if (!$result)
            return Redirect::back()->with('error', 'Error na operação');

        return Redirect::route('admin.profiles')->with('success', 'Perfil atualizado com sucesso');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $profile = $this->repository->find($id);
        if (!$profile)
            return Redirect::back()->with('error', 'Operação não autorizada');

        $result = $profile->delete();
        if (!$result)
            return Redirect::back()->with('error', 'Error na operação');

        return Redirect::route('admin.profiles')->with('success', 'Perfil removido com sucesso');
    }
}

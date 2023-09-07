<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\TenantSites;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;

class TenantSiteAdministrationController extends Controller
{
    private $repository;

    public function __construct(TenantSites $repository)
    {
        $this->repository = $repository;
        $this->middleware(['can:site']);
    }

    public function index()
    {
        $data['title']              = 'Administração de sites';
        $data['toptitle']           = 'Adminstração de sites';
        $data['breadcrumb'][]       = ['route' => route('admin.dashboard'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => 'Administração de sites', 'active' => true];
        $data['sites']              = $this->repository->latest()->paginate(8);
        $data['_sites']             = true;

        return view('admin.sites.index', $data);
    }

    public function edit($id)
    {
        $site = $this->repository->find($id);
        if(!$site) {
            return Redirect::back()->with('error', 'Operação não autorizada');
        }

        $data['title']              = 'Dados site - ' . $site->tenant->name;
        $data['toptitle']           = 'Dados site - ' . $site->tenant->name;
        $data['breadcrumb'][]       = ['route' => route('admin.dashboard'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => route('admin.sites'), 'title' => 'Administração de sites'];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => 'Dados site - ' . $site->tenant->name, 'active' => true];

        $data['site']              = $site;
        $data['_sites']             = true;

        return view('admin.sites.edit', $data);
    }

    public function update(Request $request, $id){
        $site = $this->repository->find($id);
        if(!$site) {
            return Redirect::back()->with('error', 'Operação não autorizada');
        }

        $res = $this->repository->where('id', $site->id)->update($request->except(['_token', '_method']));
        if(!$res) {
            return Redirect::back()->with('error', 'Erro na operação, tente outra vez');
        }

        return Redirect::route('admin.sites')->with('success', 'Site atualizado com sucesso');
    }
    
}

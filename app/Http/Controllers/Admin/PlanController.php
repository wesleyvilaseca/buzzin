<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdatePlan;
use Illuminate\Http\Request;
use App\Models\Plan;
use Illuminate\Support\Facades\Redirect;

class PlanController extends Controller
{
    private $repository;

    public function __construct(
        Plan $plan
    ) {
        $this->repository = $plan;
    }

    public function index()
    {
        $data['title']              = 'Planos';
        $data['toptitle']           = 'Planos';
        $data['breadcrumb'][]       = ['route' => route('admin.home'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => 'Planos', 'active' => true];
        $data['plan']               = true;
        $data['plans']              = $this->repository->latest()->paginate();

        return view('admin.plan.index', $data);
    }

    public function create()
    {
        $data['title']              = 'Novo plano';
        $data['toptitle']           = 'Novo plano';
        $data['breadcrumb'][]       = ['route' => route('admin.home'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => route('admin.plan'), 'title' => 'Planos'];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => 'Plano', 'active' => true];
        $data['plan']               = true;

        return view('admin.plan.create', $data);
    }

    public function search(Request $request)
    {
        $data['title']              = 'Planos';
        $data['toptitle']           = 'Planos';
        $data['breadcrumb'][]       = ['route' => route('admin.home'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => 'Planos', 'active' => true];
        $data['plan']               = true;
        $data['plans']              =  $this->repository->search($request->filter);
        $data['filters']            = $request->except('_token');

        return view('admin.plan.index', $data);
    }


    public function show($id)
    {
        $plan = $this->repository->find($id);

        if (!$plan)
            Redirect::back()->with('warning', 'Operação não autorizada');

        $data['title']              = 'Plano ' . $plan->name;
        $data['toptitle']           = 'Plano ' . $plan->name;
        $data['plano']              = $plan;
        $data['breadcrumb'][]       = ['route' => route('admin.home'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => route('admin.plan'), 'title' => 'Planos'];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => 'Plano ' . $plan->name, 'active' => true];
        $data['plan']               = true;

        return view('admin.plan.show', $data);
    }


    public function edit($id)
    {
        $plan = $this->repository->find($id);

        if (!$plan)
            Redirect::back()->with('warning', 'Operação não autorizada');

        $data['title']              = 'Editar plano ' . $plan->name;
        $data['toptitle']           = 'Editar plano ' . $plan->name;
        $data['plano']              = $plan;
        $data['breadcrumb'][]       = ['route' => route('admin.home'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => route('admin.plan'), 'title' => 'Planos'];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => 'Editar plano ' . $plan->name, 'active' => true];
        $data['plan']               = true;

        return view('admin.plan.edit', $data);
    }

    public function store(StoreUpdatePlan $request)
    {
        $result = $this->repository->create($request->all());
        if (!$result)
            return Redirect::back()->with('warning', 'Erro na operação');

        return Redirect::route('admin.plan')->with('success', 'Plano criado com sucesso');
    }

    public function update(StoreUpdatePlan $request, $id)
    {
        $plan = $this->repository->find($id);

        if (!$plan)
            Redirect::back()->with('warning', 'Operação não autorizada');

        $result = $plan->update($request->all());
        if (!$result)
            Redirect::back()->with('warning', 'Erro na operação');

        return Redirect::route('admin.plan')->with('success', 'Plano editado com sucesso');
    }

    public function destroy($id)
    {
        $plan = $this->repository->find($id);

        if (!$plan)
            Redirect::back()->with('warning', 'Operação não autorizada');

        if ($plan->details->count() > 0) {
            return Redirect::back()
                ->with('error', 'Existem detahes vinculados a esse plano, portanto não pode deletar');
        }

        $result = $plan->delete();
        if (!$result)
            Redirect::back()->with('warning', 'Erro na operação');

        return Redirect::route('admin.plan')->with('success', 'Plano removido com sucesso');
    }
}

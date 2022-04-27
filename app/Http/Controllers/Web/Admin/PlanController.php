<?php

namespace App\Http\Controllers\Web\Admin;

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

        $this->middleware(['can:plans']);
    }

    public function index()
    {
        // dd(auth()->user()->isAdmin());

        $data['title']              = 'Planos';
        $data['toptitle']           = 'Planos';
        $data['breadcrumb'][]       = ['route' => route('admin.dashboard'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => 'Planos', 'active' => true];
        $data['plan']               = true;
        $data['plans']              = $this->repository->latest()->paginate();

        return view('admin.plan.index', $data);
    }

    public function create()
    {
        $data['title']              = 'Novo plano';
        $data['toptitle']           = 'Novo plano';
        $data['breadcrumb'][]       = ['route' => route('admin.dashboard'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => route('admin.plan'), 'title' => 'Planos'];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => 'Plano', 'active' => true];
        $data['plan']               = true;

        return view('admin.plan.create', $data);
    }

    public function search(Request $request)
    {
        $data['title']              = 'Planos';
        $data['toptitle']           = 'Planos';
        $data['breadcrumb'][]       = ['route' => route('admin.dashboard'), 'title' => 'Dashboard'];
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
        $data['breadcrumb'][]       = ['route' => route('admin.dashboard'), 'title' => 'Dashboard'];
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
        $data['breadcrumb'][]       = ['route' => route('admin.dashboard'), 'title' => 'Dashboard'];
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

        if ($plan->name !== $request->name) {
            $exist = $this->repository->where('name', '=', $request->name)->first();
            if ($exist)
                return Redirect::back()->with('warning', 'Já existe um plano com esse nomo');
        }

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
                ->with('error', 'Existem detalhes vinculados a esse plano, portanto não pode deletar');
        }

        $result = $plan->delete();
        if (!$result)
            Redirect::back()->with('warning', 'Erro na operação');

        return Redirect::route('admin.plan')->with('success', 'Plano removido com sucesso');
    }
}

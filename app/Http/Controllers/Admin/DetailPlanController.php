<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateDetailPlan;
use App\Models\DetailPlan;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class DetailPlanController extends Controller
{
    protected $repository;
    protected $plan;

    public function __construct(
        DetailPlan $detailPlan,
        Plan $plan
    ) {
        $this->repository   = $detailPlan;
        $this->plan         = $plan;
    }

    public function index(int $id)
    {
        $plan = $this->plan->find($id);
        if (!$plan) return Redirect::back()->with('error', 'Operação não autorizada');

        $data['title']              = 'Detalhes do plano ' . $plan->name;
        $data['toptitle']           = 'Detalhes do plano ' . $plan->name;
        $data['breadcrumb'][]       = ['route' => route('admin.dashboard'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => route('admin.plan'), 'title' => 'Planos'];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => 'Detalhes do plano ' . $plan->name, 'active' => true];
        $data['details']            = $plan->details()->paginate();
        $data['plano']              = $plan;
        $data['plan']               = true;

        return view('admin.detailplan.index', $data);
    }

    public function create($id)
    {
        $plan = $this->plan->find($id);
        if (!$plan)
            return Redirect::back()->with('error', 'Operação não autorizada');

        $data['title']              = 'Novo detalhe do plano ' . $plan->name;
        $data['toptitle']           = 'Novo detalhe do plano ' . $plan->name;
        $data['breadcrumb'][]       = ['route' => route('admin.dashboard'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => route('admin.plan'), 'title' => 'Planos'];
        $data['breadcrumb'][]       = ['route' => route('details.plan.index', $plan->id), 'title' => 'Detalhes do plano ' . $plan->name];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => 'Novo detalhe do plano ' . $plan->name, 'active' => true];
        $data['details']            = $plan->details()->paginate();
        $data['plano']              = $plan;
        $data['plan']               = true;

        return view('admin.detailplan.create', $data);
    }

    public function edit(int $plan_id, int $detail_id)
    {
        $plan       = $this->plan->find($plan_id);
        $detail     = $this->repository->find($detail_id);

        if (!$plan || !$detail) return Redirect::back()->with('error', 'Operação não autorizada');

        $data['title']              = 'Editar detalhe plano ' . $detail->name;
        $data['toptitle']           = 'Editar detalhe plano ' . $detail->name;
        $data['breadcrumb'][]       = ['route' => route('admin.dashboard'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => route('admin.plan'), 'title' => 'Planos'];
        $data['breadcrumb'][]       = ['route' => route('details.plan.index', $plan->id), 'title' => 'Detalhes do plano ' . $plan->name];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => 'Editar detalhe plano ' . $detail->name, 'active' => true];
        $data['detail']             = $detail;
        $data['plano']              = $plan;
        $data['plan']               = true;

        return view('admin.detailplan.edit', $data);
    }


    public function store(StoreUpdateDetailPlan $request, $id)
    {
        $plan = $this->plan->find($id);
        if (!$plan) return Redirect::back()->with('error', 'Operação não autorizada');

        $result = $plan->details()->create($request->all());
        if (!$result)
            return Redirect::back()->with('warning', 'Erro na operação');

        return Redirect::route('details.plan.index', $plan->id)->with('success', 'Detalhe do plano criado com sucesso');
    }


    public function update(StoreUpdateDetailPlan $request, $plan_id, $detail_id)
    {
        $plan       = $this->plan->find($plan_id);
        $detail     = $this->repository->find($detail_id);

        if (!$plan || !$detail)
            return Redirect::back()->with('error', 'Operação não autorizada');

        $result = $detail->update($request->all());
        if (!$result)
            return Redirect::back()->with('warning', 'Erro na operação');

        return Redirect::route('details.plan.index', $plan->id)->with('success', 'Detalhe do plano editado com sucesso');
    }

    public function show($plan_id, $detail_id)
    {
        $plan   = $this->plan->find($plan_id);
        $detail = $this->repository->find($detail_id);

        if (!$plan || !$detail)
            return Redirect::back()->with('error', 'Operação não autorizada');

        $data['title']              = 'Detalhe plano ' . $detail->name;
        $data['toptitle']           = 'Detalhe plano ' . $detail->name;
        $data['breadcrumb'][]       = ['route' => route('admin.dashboard'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => route('admin.plan'), 'title' => 'Planos'];
        $data['breadcrumb'][]       = ['route' => route('details.plan.index', $plan->id), 'title' => 'Detalhes do plano ' . $plan->name];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => 'Detalhe plano ' . $detail->name, 'active' => true];
        $data['detail']             = $detail;
        $data['plano']              = $plan;
        $data['plan']               = true;

        return view('admin.detailplan.show', $data);
    }


    public function destroy($plan_id, $detail_id)
    {
        $plan   = $this->plan->find($plan_id);
        $detail = $this->repository->find($detail_id);

        if (!$plan || !$detail) return Redirect::back()->with('error', 'Operação não autorizada');

        $result = $detail->delete();
        if (!$result)
            return Redirect::back()->with('warning', 'Erro na operação');

        return Redirect::route('details.plan.index', $plan->id)->with('success', 'Registro removido com sucesso');
    }
}

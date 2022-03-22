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

    public function store(StoreUpdatePlan $request)
    {
        $result = $this->repository->create($request->all());
        if (!$result)
            return Redirect::back()->with('warning', 'Erro na operação');

        return redirect()->route('admin.plan')->with('success', 'Plano criado com sucesso');
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
}

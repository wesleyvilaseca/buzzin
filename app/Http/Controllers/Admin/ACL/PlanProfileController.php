<?php

namespace App\Http\Controllers\Admin\ACL;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class PlanProfileController extends Controller
{
    protected $plan;
    protected $profile;

    public function __construct(
        Plan $plan,
        Profile $profile
    ) {
        $this->plan = $plan;
        $this->profile = $profile;
    }

    public function profiles($plan_id)
    {
        $plan = $this->plan->find($plan_id);
        if (!$plan)
            return Redirect::back()->with('error', 'Operação não autorizada');

        $data['title']      = 'Perfis do plano ' . $plan->name;
        $data['toptitle']   = 'Perfis do plano ' . $plan->name;
        $data['breadcrumb'][]       = ['route' => route('admin.dashboard'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => route('admin.plan'), 'title' => 'Planos'];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => 'Perfis do plano ' . $plan->name, 'active' => true];

        $data['profiles']   = $plan->profiles()->paginate();
        $data['plan']       = $plan;

        return view('admin.plan.profiles', $data);
    }

    public function profilesAvailable(Request $request, $plan_id)
    {
        $plan = $this->plan->find($plan_id);
        if (!$plan)
            return Redirect::back()->with('error', 'Operação não autorizada');

        $data['title']              = 'Novo perfi do plano ' . $plan->name;
        $data['toptitle']           = 'Novo perfi do plano ' . $plan->name;
        $data['breadcrumb'][]       = ['route' => route('admin.dashboard'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => route('admin.plan'), 'title' => 'Planos'];
        $data['breadcrumb'][]       = ['route' => route('plans.profiles', $plan->id), 'title' => 'Perfis do plano ' . $plan->name];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => 'Novo perfi do plano ' . $plan->name, 'active' => true];
        $data['profiles']           = $plan->profilesAvailable($request->filter);
        $data['filters']            = $request->except('_token');
        $data['plan']               = $plan;

        return view('admin.plan.profiles_available', $data);
    }

    public function attachProfilesPlan(Request $request, $plan_id)
    {
        $plan = $this->plan->find($plan_id);
        if (!$plan)
            return Redirect::back()->with('error', 'Operação não autorizada');

        if (!$request->profiles || count($request->profiles) == 0)
            return Redirect::back()->with('warning', 'Precisa escolher pelo menos um plano');

        $plan->profiles()->attach($request->profiles);

        return Redirect::route('plans.profiles', $plan->id)->with('success', 'Operação efetuada com sucesso');
    }

    public function detachProfilePlan($idPlan, $idProfile)
    {
        $plan       = $this->plan->find($idPlan);
        $profile    = $this->profile->find($idProfile);

        if (!$plan || !$profile)
            return Redirect::back()->with('error', 'Operação não autorizada');

        $plan->profiles()->detach($profile);

        return Redirect::route('plans.profiles', $plan->id)->with('success', 'Operação efetuada com sucesso');
    }
}

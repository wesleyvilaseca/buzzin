<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Permission;
use App\Models\Plan;
use App\Models\Product;
use App\Models\Profile;
use App\Models\Role;
use App\Models\Table;
use App\Models\Tenant;
use App\Models\User;
use App\Services\TenantService;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    private $tenantService;

    public function __construct(TenantService $tenantService)
    {
        $this->tenantService = $tenantService;
    }

    public function index(Request $request)
    {
        $data['title']              = 'Planos';
        $data['toptitle']           = 'Planos';
        $data['subscritions']       = true;
        $data['showSubscriptionMessage'] = 'N';

        return view('admin.subscription.index', $data);
    }

    public function getPlans() {
        $plans = Plan::where('status', 1)->with('details')->get();
        return response()->json($plans, 200);
    }

    public function payCard(Request $request) {
        dd($request->all());
    }
}

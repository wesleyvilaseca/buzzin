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

class DashboardController extends Controller
{
    private $tenantService;

    public function __construct(TenantService $tenantService)
    {
        $this->tenantService = $tenantService;
        $this->middleware(function ($request, $next) {
            $this->tenantService->checkSubscription();
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $data['title']      = 'dashboard';
        $data['toptitle']   = 'Dashboard';
        $data['dashboard']       = true;

        $tenant = auth()->user()->tenant;

        $data['totalUsers'] = User::where('tenant_id', $tenant->id)->count();
        $data['totalTables'] = Table::count();
        $data['totalCategories'] = Category::count();
        $data['totalProducts'] = Product::count();
        $data['totalTenants'] = Tenant::count();
        $data['totalPlans'] = Plan::count();
        $data['totalRoles'] = Role::count();
        $data['totalProfiles'] = Profile::count();
        $data['totalPermissions'] = Permission::count();

        return view('admin.dashboard.index', $data);
    }
}

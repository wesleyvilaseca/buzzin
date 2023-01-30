<?php

namespace App\Http\Controllers\Web\AdminClient;

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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardClientController extends Controller
{
    public function index()
    {
        $data['title']      = 'dashboard';
        $data['toptitle']   = 'Dashboard';
        $data['dashboard']       = true;

        return view('admin_client.dashboard.index', $data);
    }
}

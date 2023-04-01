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
use App\Models\Transaction;
use App\Models\User;
use App\Services\TenantService;
use Illuminate\Http\Request;

class TransactionsController extends Controller
{
    private $tenantService;
    private $repository;

    public function __construct(TenantService $tenantService, Transaction $repository)
    {
        $this->tenantService = $tenantService;
        $this->repository = $repository;

    }

    public function index(Request $request)
    {
        $data['title']              = 'Transações';
        $data['toptitle']           = 'Transações';
        $data['transac']            = true;
        $data['transactions']       = $this->repository->get();

        return view('admin.transactions.index', $data);
    }
}

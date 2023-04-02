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
use Illuminate\Support\Facades\Redirect;

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
        $data['breadcrumb'][]       = ['route' => route('admin.dashboard'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => 'Minhas transações', 'active' => true];
        $data['transac']            = true;
        $data['transactions']       = $this->repository->orderBy('id', 'Desc')->paginate();

        return view('admin.transactions.index', $data);
    }

    public function show($id) {
        $transaction = $this->repository->find($id);
        if(!$transaction) {
            return Redirect::back()->with('error', 'operação não autorizada');
        }

        $transaction->data = json_decode($transaction->data);

        $data['title']              = 'Transação';
        $data['toptitle']           = 'Transação';
        $data['breadcrumb'][]       = ['route' => route('admin.dashboard'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => route('admin.transactions'), 'title' => 'Minhas transações', 'active'];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => 'Minhas transação', 'active' => true];
        $data['transac']            = true;
        $data['transaction']       = $transaction;

        return view('admin.transactions.show', $data);
    }
}

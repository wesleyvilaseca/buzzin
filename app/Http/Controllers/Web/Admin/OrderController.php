<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    private $repository;

    public function __construct(Order $plan)
    {
        $this->repository = $plan;
    }

    public function index()
    {
        $data['title']              = 'Pedidos';
        $data['toptitle']           = 'Pedidos';
        $data['breadcrumb'][]       = ['route' => route('admin.dashboard'), 'title' => 'Dashboard'];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => 'Pedidos', 'active' => true];
        $data['order_m'] = true;
        return view('admin.orders.index', $data);
    }
}

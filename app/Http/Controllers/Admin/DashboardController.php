<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // dd(auth()->user()->hasPermission('products'));
        $data['title']      = 'dashboard';
        $data['toptitle']   = 'Dashboard';
        $data['dashboard']       = true;

        return view('admin.dashboard.index', $data);
    }
}

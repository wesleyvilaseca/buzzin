<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data['title']      = 'dashboard';
        $data['toptitle']   = 'Dashboard';
        $data['dashboard']       = true;

        return view('admin.dashboard.index', $data);
    }
}

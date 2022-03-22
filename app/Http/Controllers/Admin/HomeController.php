<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $data['title']      = 'Home';
        $data['toptitle']   = 'Home';
        $data['home']       = true;

        return view('admin.home.index', $data);
    }
}

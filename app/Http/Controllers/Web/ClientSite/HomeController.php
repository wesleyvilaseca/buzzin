<?php

namespace App\Http\Controllers\Web\ClientSite;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $data['title']      = 'Home';
        return view('client_site.home.index', $data);
    }
}

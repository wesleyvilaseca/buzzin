<?php

namespace App\Http\Controllers\Web\Site;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;

class HomeController extends Controller {

    public function index() {
        $data['title']      = 'Home';
        $data['plans']      = Plan::with('details')->get()->all();

        return view('site.home.index', $data);
    }
}

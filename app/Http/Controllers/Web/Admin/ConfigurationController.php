<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class ConfigurationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['can:configuration']);
    }

    public function index()
    {
        return Redirect::route('admin.payments');
    }
}

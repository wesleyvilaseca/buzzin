<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateCategory;
use App\Models\Category;
use App\Models\Payment;
use App\Models\Site;
use App\Models\Tenant;
use App\Models\TenantPayment;
use App\Supports\Cripto\Cripto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

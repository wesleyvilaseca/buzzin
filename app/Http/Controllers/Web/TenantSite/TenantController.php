<?php

namespace App\Http\Controllers\Web\TenantSite;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\TenantResource;
use App\Models\Plan;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class TenantController extends Controller
{
    private $categoryService;
    private $tenant;

    public function __construct(CategoryService $tenant)
    {
        $this->categoryService = $tenant;

        $this->middleware(function ($request, $next) {
            $this->tenant = session()->get('tenant');
            return $next($request);
        });
    }

    public function getTenant(Request $request)
    {
        return new TenantResource($this->tenant);
    }
}

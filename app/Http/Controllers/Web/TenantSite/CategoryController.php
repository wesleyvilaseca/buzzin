<?php

namespace App\Http\Controllers\Web\TenantSite;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Plan;
use App\Services\CategoryService;
use App\Supports\Helper\Utils;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private $categoryService;
    private $tenant;

    public function __construct(CategoryService $tenant)
    {
        $this->categoryService = $tenant;

        $this->middleware(function ($request, $next) {
            $this->tenant = Utils::getCachedTenant();
            return $next($request);
        });
    }

    public function categories(Request $request)
    {
        $categories = $this->categoryService->categories($this->tenant->uuid);
        return CategoryResource::collection($categories);
    }

    public function show(Request $request, $identify)
    {
        if (!$category = $this->categoryService->getCategoryByUrl($identify)) {
            return response()->json(['message' => 'Category Not Found'], 404);
        }
        return new CategoryResource($category);
    }
}

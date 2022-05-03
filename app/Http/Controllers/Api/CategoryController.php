<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\TenantRequest;
use App\Http\Resources\CategoryResource;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private $categoryService;

    public function __construct(CategoryService $tenant)
    {
        $this->categoryService = $tenant;
    }

    public function categories(TenantRequest $request)
    {
        $categories = $this->categoryService->categories($request->uuid);

        return CategoryResource::collection($categories);
    }
}

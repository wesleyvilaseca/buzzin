<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\TenantRequest;
use App\Http\Resources\CategoryResource;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class WhatsappController extends Controller
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

    public function show(TenantRequest $request, $identify)
    {
        if (!$category = $this->categoryService->getCategoryByUrl($identify)) {
            return response()->json(['message' => 'Category Not Found'], 404);
        }

        return new CategoryResource($category);
    }
}

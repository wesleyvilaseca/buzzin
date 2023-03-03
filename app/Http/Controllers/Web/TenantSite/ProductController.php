<?php

namespace App\Http\Controllers\Web\TenantSite;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Plan;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;
    private $tenant;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
        $this->middleware(function ($request, $next) {
            $this->tenant = session()->get('tenant');
            return $next($request);
        });
    }

    public function productsByTenant(Request $request)
    {
        $products = $this->productService->getProductsByTenantUuid(
            $this->tenant->uuid,
            $request->get('categories', [])
        );

        return ProductResource::collection($products);
    }

    // public function show(TenantRequest $request, $identify)
    // {
    //     if (!$product = $this->productService->getProductByUuid($identify)) {
    //         return response()->json(['message' => 'Product Not Found'], 404);
    //     }

    //     return new ProductResource($product);
    // }
}

<?php

namespace App\Http\Controllers\Web\TenantSite;

use App\Http\Controllers\Controller;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class CheckoutController extends Controller
{
    private $tenant;
    private $client;
    private $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
        $this->middleware(function ($request, $next) {
            $this->tenant = session()->get('tenant');
            return $next($request);
        });
    }

    public function index()
    {
        $data['title']      = 'Checkout - ' . $this->tenant->url;
        return view('tenant_site.checkout.index', $data);
    }

    /**
     * metodo depreciado, usar apenas a rota da api
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = [];
            $data = $request->all();
            $data['token_company'] = $this->tenant->uuid;
            DB::commit();
            return  $this->orderService->createNewOrder($data);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Houve um erro na requisição, tente novamento', 'detail' => $e->getMessage()], 404);
        }
    }
}

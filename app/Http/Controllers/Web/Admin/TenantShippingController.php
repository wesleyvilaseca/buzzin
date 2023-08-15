<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateCategory;
use App\Models\Category;
use App\Models\Payment;
use App\Models\Shipping;
use App\Models\Site;
use App\Models\Tenant;
use App\Models\TenantPayment;
use App\Models\TenantShipping;
use App\Supports\Cripto\Cripto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class TenantShippingController extends Controller
{
    private $tenantShipping;
    private $shipping;

    public function __construct(TenantShipping $tenantShipping, Shipping $shipping)
    {
        $this->tenantShipping = $tenantShipping;
        $this->shipping = $shipping;

        $this->middleware(['can:tenant_shippment']);
    }

    public function index()
    {
        $data['title']              = 'Formas de entrega';
        $data['_configuration']     = true;
        $data['_delivery']          = true;

        $data['shippings']          = $this->shipping->where('status', 1)->get();
        $data['tenantShippings']     = $this->tenantShipping->get();

        return view('admin.configuration.shipping', $data);
    }

    public function active(Request $request)
    {
        if (!$request->shipping_id) {
            return Redirect::back()->with('error', 'Operação não autorizada');
        }

        $shippingMethodExist = $this->shipping->find($request->shipping_id);
        if (!$shippingMethodExist) {
            return Redirect::back()->with('error', 'Operação não autorizada');
        }

        $hasShippingMethod = $this->tenantShipping->where('shipping_id', $request->shipping_id)->first();
        if ($hasShippingMethod) {
            return Redirect::back()->with('error', 'Operação não autorizada');
        }

        $res = $this->tenantShipping->create([
            'shipping_id' => $request->shipping_id,
            'alias' => $shippingMethodExist->alias,
            'status' => 1
        ]);

        if (!$res) {
            return Redirect::back()->with('error', 'Erro ao habilitar a forma de entrega');
        }

        return Redirect::route('admin.shippings')->with('success', "Forma entrega habilitado com sucesso");
    }

    public function disable(Request $request, $id)
    {
        $tenantShipping = $this->tenantShipping->find($id);
        if (!$tenantShipping) {
            return Redirect::back()->with('error', 'Operação não autorizada');
        }

        $tenantShipping->update(['status' => 0]);

        return Redirect::route('admin.shippings')->with('success', "Forma de entrega desabilitado com sucesso");
    }

    public function enable(Request $request, $id)
    {
        $tenantShipping = $this->tenantShipping->find($id);
        if (!$tenantShipping) {
            return Redirect::back()->with('error', 'Operação não autorizada');
        }

        $tenantShipping->update(['status' => 1]);

        return Redirect::route('admin.shippings')->with('success', "Forma de entrega habilitado com sucesso");
    }
}

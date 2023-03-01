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

class TenantPaymentsController extends Controller
{
    private $tenantPayment;
    private $payment;

    public function __construct(TenantPayment $tenantPayment, Payment $payment)
    {
        $this->tenantPayment = $tenantPayment;
        $this->payment = $payment;

        $this->middleware(['can:tenant_payment']);
    }

    public function index()
    {
        $data['title']              = 'Formas de pagamentos';
        $data['_configuration']     = true;
        $data['_payment']           = true;

        $data['payments']           = $this->payment->where('status', 1)->get();
        $data['tenantPayments']     = $this->tenantPayment->get();
        return view('admin.configuration.payment', $data);
    }

    public function active(Request $request)
    {
        if (!$request->payment_id) {
            return Redirect::back()->with('error', 'Operação não autorizada');
        }

        $paymentMethodExist = $this->payment->find($request->payment_id);
        if (!$paymentMethodExist) {
            return Redirect::back()->with('error', 'Operação não autorizada');
        }

        $hasPaymentMethod = $this->tenantPayment->where('payment_id', $request->payment_id)->first();
        if ($hasPaymentMethod) {
            return Redirect::back()->with('error', 'Operação não autorizada');
        }

        $res = $this->tenantPayment->create([
            'payment_id' => $request->payment_id,
            'status' => 1
        ]);

        if (!$res) {
            return Redirect::back()->with('error', 'Erro ao habilitar a forma de pagamento');
        }

        return Redirect::route('admin.payments')->with('success', "Paymento habilitado com sucesso");
    }

    public function disable(Request $request, $id)
    {
        $tenantPayment = $this->tenantPayment->find($id);
        if (!$tenantPayment) {
            return Redirect::back()->with('error', 'Operação não autorizada');
        }

        $tenantPayment->update(['status' => 0]);

        return Redirect::route('admin.payments')->with('success', "Paymento desabilitado com sucesso");
    }

    public function enable(Request $request, $id)
    {
        $tenantPayment = $this->tenantPayment->find($id);
        if (!$tenantPayment) {
            return Redirect::back()->with('error', 'Operação não autorizada');
        }

        $tenantPayment->update(['status' => 1]);

        return Redirect::route('admin.payments')->with('success', "Paymento habilitado com sucesso");
    }
}

<?php

namespace App\Http\Controllers\Web\Admin\PaymentIntegration;

use App\Http\Controllers\Controller;
use App\Models\Site;
use App\Models\SiteTenantExtensions;
use App\Models\TenantPayment;
use App\Supports\Cripto\Cripto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class MercadoPagoIntegrationController extends Controller
{
    use Cripto;
    private $site;

    public function __construct(Site $site)
    {
        $this->site = $site;
    }

    public function index($id)
    {
        $payment = TenantPayment::find($id);
        if (!$payment) return Redirect::back()->with('error', 'Operação não autorizada');
        if (@isset($payment->data)) {
            $payment->data = json_decode($payment->data);
        }

        $data['title']              = 'Configuração do mercado pago';
        $data['toptitle']           = 'Configuração do mercado pago';
        $data['_configuration']     = true;
        $data['_payment']           = true;
        $data['site']               = $this->site->first();;

        $data['breadcrumb_config'][]       = ['route' => route('admin.dashboard'), 'title' => 'Dashboard'];
        $data['breadcrumb_config'][]       = ['route' => route('admin.payments'), 'title' => 'Formas de pagamento'];
        $data['breadcrumb_config'][]       = ['route' => '#', 'title' => 'Configuração pagamento do mercado pago', 'active' => true];
        $data['payment'] = $payment;

        return view('admin.configuration.payment_integrations.mercadopago', $data);
    }

    public function store(Request $request, $id)
    {
        $exist = TenantPayment::find($id);
        if (!$exist) return Redirect::route('admin.payments')->with('error', 'Operação não autorizada');

        $validate = Validator::make($request->all(), [
            'public_key' =>  ['required'],
            'access_token' => ['required'],
        ]);

        if ($validate->fails()) {
            return Redirect::back()->with('error', $validate->errors());
        }

        $exist->update(['data' => json_encode($request->except(['_token']))]);

        return Redirect::route('admin.payments')->with('success', "Configurações do mercado pago atualizada com sucesso");
    }
}

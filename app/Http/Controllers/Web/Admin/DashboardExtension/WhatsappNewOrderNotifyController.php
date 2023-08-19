<?php

namespace App\Http\Controllers\Web\Admin\DashboardExtension;

use App\Http\Controllers\Controller;
use App\Models\DashboardExtensionTenant;
use App\Models\SiteTenantExtensions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class WhatsappNewOrderNotifyController extends Controller
{

    public function __construct()
    {
        //porque é uma ação que só funciona se ele tiver site
        $this->middleware(['can:site']);
    }

    public function index($id)
    {
        $extension = DashboardExtensionTenant::find($id);
        if (!$extension) {
            return Redirect::back()->with('error', 'Operação não autorizada');
        }

        if (@isset($extension->data)) {
            $extension->data = json_decode($extension->data);
        }

        $data['title']                  = 'Configurações noticação de venda por whatsapp';
        $data['toptitle']               = $data['title'];
        $data['_configuration']          = true;
        $data['_dashboardextensions']    = true;

        $data['breadcrumb_config'][]       = ['route' => route('admin.dashboard'), 'title' => 'Dashboard'];
        $data['breadcrumb_config'][]       = ['route' => route('admin.dashboad_extensions'), 'title' => 'Dashboard - Extensões'];
        $data['breadcrumb_config'][]       = ['route' => '#', 'title' => $data['title'], 'active' => true];
        $data['extension'] = $extension;

        return view('admin.configuration.extensions_form.whatsapp_neworder_notify', $data);
    }

    public function store(Request $request, $id)
    {
        $exist = DashboardExtensionTenant::find($id);
        if (! $exist) {
            return Redirect::route('admin.dashboad_extensions')->with('error', 'Operação não autorizada');
        }

        $validate = Validator::make($request->all(), [
            'number' =>  ['required'],
            'token' => ['required'],
        ]);

        if ($validate->fails()) {
            return Redirect::back()->with('error', $validate->errors());
        }

        $exist->update(['data' => json_encode($request->except(['_token']))]);

        return Redirect::route('admin.dashboad_extensions')->with('success', "Extenção atualizada com sucesso");
    }
}

<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\DashboardExtension;
use App\Models\DashboardExtensionTenant;
use App\Models\Site;
use App\Models\SiteExtensions;
use App\Models\SiteTenantExtensions;
use App\Supports\Cripto\Cripto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class DashBoardExtensionsController extends Controller
{
    use Cripto;
    private $repository;

    public function __construct(Site $repository)
    {
        $this->repository = $repository;
        $this->middleware(['can:site']);
    }

    public function index()
    {
        $site = $this->repository->first();
        $data['title']              = 'Dashboard - Extensões';
        $data['toptitle']           = 'Dashboard - Extensões';
        $data['_configuration']          = true;
        $data['_dashboardextensions']    = true;
        $data['site']               = $site;
        $data['extensions'] = DashboardExtension::where('status', 1)->paginate();
        $data['tenantExtensions'] = DashboardExtensionTenant::get();

        return view('admin.configuration.extensions', $data);
    }

    public function active(Request $request)
    {
        if (!$request->extension_id) {
            return Redirect::back()->with('error', 'Operação não autorizada');
        }

        $extensionExist = DashboardExtension::find($request->extension_id);
        if (!$extensionExist) {
            return Redirect::back()->with('error', 'Operação não autorizada');
        }

        $hasExtension = DashboardExtensionTenant::where('dashboard_extension_id', $request->extension_id)->first();
        if ($hasExtension) {
            return Redirect::back()->with('error', 'Operação não autorizada');
        }

        $res = DashboardExtensionTenant::create([
            'dashboard_extension_id' => $extensionExist->id,
            'alias' => $extensionExist->alias,
            'status' => 1
        ]);

        if (!$res) {
            return Redirect::back()->with('error', 'Erro ao habilitar a extensão de entrega');
        }

        return Redirect::route('admin.dashboad_extensions')->with('success', "Extenção habilitado com sucesso");
    }

    public function disable(Request $request, $id)
    {
        $tenantExtension = DashboardExtensionTenant::find($id);
        if (!$tenantExtension) {
            return Redirect::back()->with('error', 'Operação não autorizada');
        }

        $tenantExtension->update(['status' => 0]);

        return Redirect::route('admin.dashboad_extensions')->with('success', "Extenção desabilitado com sucesso");
    }

    public function enable(Request $request, $id)
    {
        $tenantExtension =  DashboardExtensionTenant::find($id);
        if (!$tenantExtension) {
            return Redirect::back()->with('error', 'Operação não autorizada');
        }

        $tenantExtension->update(['status' => 1]);

        return Redirect::route('admin.dashboad_extensions')->with('success', "Extenção habilitado com sucesso");
    }
}

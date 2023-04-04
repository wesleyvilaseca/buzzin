<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Site;
use App\Models\SiteExtensions;
use App\Models\SiteTenantExtensions;
use App\Supports\Cripto\Cripto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class SiteExtensionsController extends Controller
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
        $data['title']              = 'Site - Extenções';
        $data['toptitle']           = 'Site - Extenções';
        $data['_sitearea']          = true;
        $data['_siteextensions']    = true;
        $data['site']               = $site;

        $siteLink = function ($site) {
            $linkSite = '';
            $isInMaintence = $site->maintence == 1 ? true : false;
            if (!$isInMaintence) {
                $linkSite = $site->subdomain;
                return $linkSite;
            }
            $params = (object)[
                'domain' => $site->subdomain
            ];

            $encript = Cripto::encrypt($params, true);
            $linkSite = $site->subdomain . '?params=' . $encript;
            return $linkSite;
        };

        $data['linkWebSite'] = @$site ? $siteLink($site) : null;
        $data['extensions'] = SiteExtensions::where('status', 1)->paginate();
        $data['tenantExtensions'] = SiteTenantExtensions::get();

        return view('admin.site.extensions', $data);
    }

    public function active(Request $request)
    {
        if (!$request->extension_id) {
            return Redirect::back()->with('error', 'Operação não autorizada');
        }

        $extensionExist = SiteExtensions::find($request->extension_id);
        if (!$extensionExist) {
            return Redirect::back()->with('error', 'Operação não autorizada');
        }

        $hasExtension = SiteTenantExtensions::where('site_extension_id', $request->extension_id)->first();
        if ($hasExtension) {
            return Redirect::back()->with('error', 'Operação não autorizada');
        }

        $res = SiteTenantExtensions::create([
            'site_extension_id' => $request->extension_id,
            'status' => 1
        ]);

        if (!$res) {
            return Redirect::back()->with('error', 'Erro ao habilitar a extensão de entrega');
        }

        return Redirect::route('admin.site.extensions')->with('success', "Extenção habilitado com sucesso");
    }

    public function disable(Request $request, $id)
    {
        $tenantExtension = SiteTenantExtensions::find($id);
        if (!$tenantExtension) {
            return Redirect::back()->with('error', 'Operação não autorizada');
        }

        $tenantExtension->update(['status' => 0]);

        return Redirect::route('admin.site.extensions')->with('success', "Extenção desabilitado com sucesso");
    }

    public function enable(Request $request, $id)
    {
        $tenantExtension =  SiteTenantExtensions::find($id);
        if (!$tenantExtension) {
            return Redirect::back()->with('error', 'Operação não autorizada');
        }

        $tenantExtension->update(['status' => 1]);

        return Redirect::route('admin.site.extensions')->with('success', "Extenção habilitado com sucesso");
    }
}

<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Site;
use App\Models\Tenant;
use App\Supports\Cripto\Cripto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class SiteController extends Controller
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
        $data['title']              = 'Site';
        $data['toptitle']           = 'Meu site';
        $data['_site']              = true;

        if (@isset($site->data)) {
            $site->data = json_decode($site->data);
        }

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

        return view('admin.site.index', $data);
    }

    public function enable(Request $request)
    {
        $exist = $this->repository->first();
        if ($exist) return Redirect::route('admin.site')->with('warning', 'A empresa já possui um site cadastrado');

        $tenant = Tenant::find(Auth::user()->tenant_id);

        $data = [
            'domain' => null,
            'subdomain' => str_replace('-', '', $tenant->url) . '.' . request()->getHttpHost(),
            'maintence' => 1,
            'status' => 0
        ];

        $res = $this->repository->create($data);
        if (!$res) return Redirect::route('admin.site')->with('warning', 'Houve um erro ao ativar o seu site, tente outra vez');

        return Redirect::route('admin.site')->with('success', 'Site ativado com sucesso');
    }

    public function storeUpdateLayout(Request $request)
    {
        $site = $this->repository->first();
        $tab = $request->get('tab');

        if (!$site) {
            return Redirect::back()->with('error', 'Operação não autorizada');
        }

        $datalayout = (object)[
            'btn_color' => $request->btn_color,
            'btn_color_hover' => $request->btn_color_hover,
            'btn_color_letter' => $request->btn_color_letter,
            'links' => $request->links,
            'links_hover' => $request->links_hover
        ];

        $data = json_decode($site->data);
        $layout = (array) @$data?->layout;

        if ($layout) {
            $data->layout = (object)[
                ...$layout,
                "paleta_cores_site" => $datalayout
            ];
        }

        if (!$layout) {
            $data = (array) $data;
            $data['layout'] = (object)[
                "paleta_cores_site" => $datalayout
            ];
        }

        $res = $this->repository->where('id', $site->id)->update(['data' => json_encode($data)]);
        if (!$res) {
            return Redirect::route('admin.site', ['tab' => $tab])->with('warning', 'Erro na operação, tente novamente');
        }

        return Redirect::route('admin.site', ['tab' => $tab])->with('success', 'Layout salvo com sucesso');
    }
}

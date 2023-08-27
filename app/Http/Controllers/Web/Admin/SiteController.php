<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Site;
use App\Models\Tenant;
use App\Supports\Cripto\Cripto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

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
        $data['_sitearea']          = true;
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
        if ($exist) {
            return Redirect::route('admin.site')->with('warning', 'A empresa já possui um site cadastrado');
        }

        if (@$request->domain) {
            if ($request->domain == env('APP_URL')) {
                return Redirect::route('admin.site')->with('error', 'Operação não autorizada'); 
            }

            $res = $this->repository->where([
                "domain" => $request->domain,
                "status_domain" => 1
            ])->first();

            if ($res) {
                return Redirect::route('admin.site')->with('warning', 'Já existe um site com esse dominio registrado e ativo');
            }
        }

        $tenant = Tenant::find(Auth::user()->tenant_id);

        $data = [
            'domain' => @$request->domain ?? null,
            'subdomain' => str_replace('-', '', $tenant->url) . '.' . request()->getHttpHost(),
            'maintence' => 1,
            'status' => 0
        ];

        $res = $this->repository->create($data);
        if (!$res) return Redirect::route('admin.site')->with('warning', 'Houve um erro ao ativar o seu site, tente outra vez');

        return Redirect::route('admin.site')->with('success', 'Site ativado com sucesso');
    }

    public function maintence(Request $request) {
        $validate = Validator::make($request->all(), [
            'maintence' => ['required'],
        ]);

        if ($validate->fails()) {
            return Redirect::route('admin.site')->with("errors", $validate->errors());
        }

        $site = $this->repository->first();
        if(!$site) {
            return Redirect::back()->with('error', 'Operação não autorizada');
        }

        $res = $site->update(['maintence' => $request->maintence]);
        if(!$res) {
            return Redirect::route('admin.site')->with('error', 'Erro na operação, tente novamente');
        }

        return Redirect::route('admin.site')->with('success', 'Operação realizada com sucesso');
    }
}

<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Site;
use App\Models\Tenant;
use App\Supports\Cripto\Cripto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class SiteLayoutController extends Controller
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
        $data['title']              = 'Site - Layout';
        $data['toptitle']           = 'Site - Layout';
        $data['_sitearea']              = true;
        $data['_sitelayout']        = true;
        $data['site']               = $site;
        return view('admin.site.layout', $data);
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

        $data = $site->data;
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
            return Redirect::route('admin.site.layout')->with('warning', 'Erro na operação, tente novamente');
        }

        return Redirect::route('admin.site.layout')->with('success', 'Layout salvo com sucesso');
    }
}

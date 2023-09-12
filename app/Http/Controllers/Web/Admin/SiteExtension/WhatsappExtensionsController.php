<?php

namespace App\Http\Controllers\Web\Admin\SiteExtension;

use App\Http\Controllers\Controller;
use App\Models\Site;
use App\Models\SiteExtensions;
use App\Models\SiteTenantExtensions;
use App\Supports\Cripto\Cripto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class WhatsappExtensionsController extends Controller
{
    use Cripto;
    private $site;

    public function __construct(Site $site)
    {
        $this->site = $site;
        $this->middleware(['can:site']);
    }

    public function index($id)
    {
        $extension = SiteTenantExtensions::find($id);
        if (!$extension) return Redirect::back()->with('error', 'Operação não autorizada');
        if (@isset($extension->data)) {
            $extension->data = json_decode($extension->data);
        }

        $data['title']              = 'Configurações da extenção whatsapp';
        $data['toptitle']           = 'Configurações da extenção whatsapp';
        $data['_sitearea']          = true;
        $data['_siteextensions']    = true;
        $data['site']               = $this->site->first();
        $data['breadcrumb_config'][]       = ['route' => route('admin.dashboard'), 'title' => 'Dashboard'];
        $data['breadcrumb_config'][]       = ['route' => route('admin.site.extensions'), 'title' => 'Site - Extensões'];
        $data['breadcrumb_config'][]       = ['route' => '#', 'title' => 'Configurações da extenção whatsapp', 'active' => true];
        $data['extension'] = $extension;

        return view('admin.site.extensions_form.whatsapp', $data);
    }

    public function store(Request $request, $id)
    {
        $exist = SiteTenantExtensions::find($id);
        if (!$exist) return Redirect::route('admin.site.extensions')->with('error', 'Operação não autorizada');

        $validate = Validator::make($request->all(), [
            'number' =>  ['required'],
            'message' => ['required', 'min:8'],
        ]);

        if ($validate->fails()) {
            return Redirect::back()->with('error', $validate->errors());
        }

        $request->merge([
            'link' => "https://api.whatsapp.com/send?phone=55" . celular($request->number) . "&text=" . urldecode($request->message)
        ]);

        $exist->update(['data' => json_encode($request->except(['_token']))]);

        return Redirect::route('admin.site.extensions')->with('success', "Extenção atualizada com sucesso");
    }
}

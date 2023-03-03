<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class TenantAccountController extends Controller
{
    private $tenant;

    public function __construct(Tenant $tenant)
    {
        $this->tenant = $tenant;
        $this->middleware(['can:tenant_account']);
    }

    public function index()
    {
        $data['title']              = 'Minha conta';
        $data['_configuration']     = true;
        $data['_myaccount']         = true;

        $data['tenant']          = $this->tenant->find(Auth::user()->tenant_id);

        return view('admin.configuration.myaccount', $data);
    }


    public function updatePassword(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'password'              => ['required', 'min:8'],
            'new_password'          => ['required', 'min:8'],
            'new_password_confirm'  => ['required', 'min:8'],
        ]);

        if ($validate->fails()) {
            return Redirect::back()->with('error', $validate->errors());
        }

        if (!Hash::check($request->password, Auth::user()->password)) {
            return Redirect::back()->with('warning', 'Senha atual incorreta');
        }

        if ($request->new_password !== $request->new_password_confirm) {
            return Redirect::back()->with('warning', 'A nova senha está diferente da senha de confirmação');
        }

        $res = User::where('id', Auth::user()->id)->update(['password' => Hash::make($request->new_password)]);
        if (!$res) {
            return Redirect::back()->with('error', 'Erro ao atualizar a senha, tente novamente');
        }

        return Redirect::back()->with('success', 'Senha atualizada com sucesso');
    }

    public function updateData(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'zip_code'         => ['required'],
            'city'             => ['required'],
            'state'            => ['required'],
            'state'            => ['required'],
            'district'         => ['required'],
            'address'          => ['required'],
        ]);

        if ($validate->fails()) {
            return Redirect::back()->with('error', $validate->errors());
        }

        $tenant = $this->tenant->find(Auth::user()->tenant_id);

        if (!$tenant->logo && !$request->hasFile('image')) {
            return Redirect::back()->with('warning', 'O logo da sua empresa é um campo obrigatório');
        }

        $validate = Validator::make($request->all(), [
            'image'          => ['required', 'file', 'max:2000', 'mimes:jpeg,jpg,png'],
        ]);

        if ($validate->fails()) {
            return Redirect::back()->with('error', $validate->errors());
        }

        $data['address'] = $request->address;
        $data['state'] = $request->state;
        $data['zip_code'] = $request->zip_code;
        $data['district'] = $request->district;
        $data['city'] = $request->city;
        $data['number'] = $request->number ?? null;

        if ($request->hasFile('image') && $request->image->isValid()) {
            if (Storage::exists($tenant->logo)) {
                Storage::delete($tenant->logo);
            }
            $data['logo'] = $request->image->store("public/tenants/{$tenant->uuid}/logo");
        }

        $res = $this->tenant->where('uuid', $tenant->uuid)->update($data);
        if (!$res) {
            return Redirect::back()->with('warning', 'Erro ao atualizar, tente novamente mais tarde');
        }

        return Redirect::back()->with('success', 'Dados atualizados com sucesso');
    }
}

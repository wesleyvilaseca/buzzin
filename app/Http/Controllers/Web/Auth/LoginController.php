<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller {
    //
    public function index() {
        $data['title'] = 'Login';
        return view('auth.admin.login', $data);
    }

    public function auth(Request $request) {
        $validate = Validator::make($request->all(), [
            'email'         => ['required'],
            'password'      => ['required'],
            'tipo_login'    => ['required']
        ]);

        if ($validate->fails()) {
            return Redirect::back()->with('error', $validate->errors());
        }

        if ($request->tipo_login == 1) {
            if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                return Redirect::back()->with('error', 'User not found');
            };
        }

        if ($request->tipo_login == 2) {
            if (!Auth::guard('client')->attempt(['email' => $request->email, 'password' => $request->password])) {
                return Redirect::back()->with('error', 'User not found');
            };
        }

        request()->session()->put('tipo_login', $request->tipo_login);

        return Redirect::route($request->tipo_login == 1 ? 'admin.dashboard' : 'client.dashboard');
    }

    public function logout() {
        Auth::logout();
        return Redirect::route('login');
    }
}

<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Cookie;

class LoginController extends Controller
{
    //
    public function index()
    {
        $data['title'] = 'Login';
        return view('auth.admin.login', $data);
    }

    public function auth(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email'         => ['required'],
            'password'      => ['required'],
        ]);

        if ($validate->fails()) {
            return Redirect::back()->with('error', $validate->errors());
        }

        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return Redirect::back()->with('error', 'User not found');
        };

        Cookie::queue('admlogin', 'S', 3800);
        return Redirect::route('admin.dashboard');
    }

    public function logout()
    {
        Auth::logout();
        Cookie::queue(Cookie::forget('admlogin'));
        return Redirect::route('login');
    }
}

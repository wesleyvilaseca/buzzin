<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use App\Mail\RecoverEmail;
use App\Mail\RecoverEmailSuccess;
use App\Models\User;
use Carbon\Carbon;
use Error;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

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

    public function recover()
    {
        $data['title'] = 'Recuperar acesso';
        return view('auth.admin.recover', $data);
    }

    public function newPassword(Request $request, $token)
    {
        $data['title'] = 'Recuperar acesso';
        $data['token'] = $token;
        $data['email'] = $request->get("email");
        return view('auth.admin.reset_password', $data);
    }

    public function resetPasswordStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8',
            'password_confirm' => 'required|min:8',
            'token' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors(['email' => 'Please complete the form']);
        }

        if ($request->password !== $request->password_confirm) {
            return Redirect::back()->with('warning', 'A senha e a confirmação da senha precisam ser iguais');
        }

        DB::beginTransaction();
        try {

            $password = $request->password;
            $tokenData = DB::table('password_resets')->where('token', $request->token)->first();
            if (!$tokenData) return Redirect::back('error', 'Operação não autorizada');

            $user = User::where('email', $tokenData->email)->first();
            if (!$user) return Redirect::back()->with('error', 'Operação não autorizada');
            $user->password = Hash::make($password);
            $user->update();

            Auth::login($user);

            DB::table('password_resets')->where('email', $user->email)->delete();
            Mail::to($user->email)->send(new RecoverEmailSuccess($user));

            DB::commit();
            return Redirect::route('admin.dashboard')->with('success', 'Conta recuperada com sucesso');
        } catch (Exception $e) {
            DB::rollback();
            return Redirect::back()->with('error', 'Erro na operação, tente novamente');
        }
    }

    public function sendRecover(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email'         => ['required'],
        ]);

        if ($validate->fails()) {
            return Redirect::back()->with('error', $validate->errors());
        }

        DB::beginTransaction();
        try {
            $user = User::where('email', '=', $request->email)->first();
            if (!$user) {
                return Redirect::back()->with('error', 'Credenciais inválidas');
            }

            DB::table('password_resets')->insert([
                'email' => $request->email,
                'token' =>  Str::random(60),
                'created_at' => Carbon::now()
            ]);

            $tokenData = DB::table('password_resets')->where('email', $request->email)->first();

            $link = env('APP_URL') . '/password/reset/' .  $tokenData->token . '?email=' . urlencode($user->email);
            Mail::to($user->email)->send(new RecoverEmail($link, $user));

            DB::commit();
            return Redirect::route('login')->with('success', 'Foi enviado um email com os dados de recuperação de sua conta, verifique seu email.');
        } catch (Exception $e) {
            DB::rollback();
            return Redirect::back()->with('error', 'Credenciais inválidas');
        }
    }
}

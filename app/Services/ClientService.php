<?php

namespace App\Services;

use App\Http\Resources\ClientResource;
use App\Mail\RecoverEmailClient;
use App\Mail\RecoverEmailSuccessClient;
use App\Models\Client;
use App\Models\Site;
use App\Repositories\Contracts\ClientRepositoryInterface;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ClientService
{
    protected $clientRepository;

    public function __construct(ClientRepositoryInterface $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    public function createNewClient(array $data)
    {
        $mobilePhoneIsValid = celular($data['mobile_phone']);
        if (!$mobilePhoneIsValid) {
            return response()->json((object)[
                'errors' => (object)[
                    'mobile_phone' => ['Número de telefone é inválido']
                ]
            ], 422);
        }

        $existEmail = Client::where('email', $data['email'])->first();
        if($existEmail) {
            return response()->json((object)[
                'errors' => (object)[
                    'email' => ['Email já possui cadastro']
                ]
            ], 422);
        }

        $existMobilePhone = Client::where('mobile_phone', $mobilePhoneIsValid)->first();
        if($existMobilePhone) {
            return response()->json((object)[
                'errors' => (object)[
                    'mobile_phone' => ['Telefone já possui cadastro']
                ]
            ], 422);
        }

        $data['mobile_phone'] = $mobilePhoneIsValid;
        $client = $this->clientRepository->createNewClient($data);
        return new ClientResource($client);
    }

    public function updatePasswordAccount(array $data)
    {
        $validate = Validator::make($data, [
            'new_password' => ['required', 'min:8'],
            'new_password_confirm' => ['required', 'min:8'],
        ]);

        if ($validate->fails()) {
            return response()->json((object) ["errors" => $validate->errors()], 400);
        }

        if ($data['new_password'] !== $data['new_password_confirm']) {
            return response()->json((object)[
                'errors' => (object)[
                    'new_password' => ['A senha e confirmação da senha precisam ser iguais'],
                    'new_password_confirm' => ['A senha e confirmação da senha precisam ser iguais']
                ]
            ], 422);
        }

        $client_id = $this->getClientId();
        $res = Client::where('id', $client_id)->update(['password' => bcrypt($data['new_password'])]);

        if (!$res) {
            return response()->json(['message' => 'Erro na operação'], 403);
        }

        return response()->json(['message' => 'Senha atualizado com sucesso'], 200);
    }

    public function update(array $data)
    {
        $validate = Validator::make($data, [
            'name' => ['required'],
            'email' => ['required'],
            'mobile_phone' => ['required'],
            'cpf' => ['required']
        ]);

        if ($validate->fails()) {
            return response()->json((object) ["errors" => $validate->errors()], 400);
        }

        $client_id = $this->getClientId();
        $data['cpf'] = decript($data['cpf']);

        $validateCpf = $this->validateCpf($data['cpf'], $client_id);
        if (sizeof($validateCpf) > 0) {
            return response()->json((object) ["errors" => $validateCpf], 400);
        }

        $mobilePhoneIsValid = celular(decript($data['mobile_phone']));
        if (!$mobilePhoneIsValid) {
            return response()->json((object)[
                'errors' => (object)[
                    'mobile_phone' => ['Número de telefone é inválido']
                ]
            ], 422);
        }

        $data['mobile_phone'] = $mobilePhoneIsValid;

        $res = Client::where('id', $client_id)->update($data);
        if (!$res) {
            return response()->json(['message' => 'Erro na operação'], 403);
        }

        return response()->json(['message' => 'Cliente atualizado com sucesso'], 200);
    }

    public function getClientById(int $id)
    {
        return Client::find($id);
    }

    public function getClientByCpf(string $cpf)
    {
        return Client::where('cpf', $cpf)->first();
    }

    public function validateCpf(string $cpf, $clientId)
    {
        $errors = [];
        $client = $this->getClientById($clientId);
        if (!$client) {
            $errors['cpf'][] = 'Cliente não localizado';
        }

        if ($client->cpf && unMaskCPF($cpf) !== $client->cpf) {
            $unMaskcpf = unMaskCPF($cpf);
            $exist = $this->getClientByCpf($unMaskcpf);
            if ($exist) {
                $errors['cpf'][] = 'Já existe um cadastro com esta credencial';
            }
        }

        if (!validaCPF($cpf)) {
            $errors['cpf'][] = 'O CPF informado é inválido';
        }

        return $errors;
    }

    public function sendRecoverPassord(array $data, $tenant)
    {
        $validate = Validator::make($data, [
            'email'         => ['required'],
        ]);

        if ($validate->fails()) {
            return response()->json((object) ["errors" => $validate->errors()], 402);
        }

        DB::beginTransaction();
        try {
            $user = Client::where('email', '=', $data['email'])->first();
            if (!$user) {
                $errors['email'][] = 'Registro não localizado';
                return response()->json((object) ["errors" => $errors], 400);
            }

            DB::table('password_resets')->insert([
                'email' => $data['email'],
                'token' =>  Str::random(60),
                'created_at' => Carbon::now()
            ]);

            $tokenData = DB::table('password_resets')->where('email', $data['email'])->first();
            $siteTenant = Site::where('tenant_id', $tenant->id)->first();
            $http = env('APP_ENV') == 'local' ? 'http://' : 'https://';
            $link = $http . $siteTenant->subdomain . '/app/password/reset/' .  $tokenData->token . '?email=' . urlencode($user->email);
            Mail::to($user->email)->send(new RecoverEmailClient($link, $user));

            DB::commit();
            return response()->json(['message' => 'Foi enviado um email com os dados de recuperação de sua conta, verifique seu email.'], 200);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Erro na operação, tente novamente']);
        }
    }

    public function resetPassword(array $data)
    {
        $validate = Validator::make($data, [
            'password' => 'required|min:8',
            'confirm_password' => 'required|min:8',
        ]);

        if ($validate->fails()) {
            return response()->json((object) ["errors" => $validate->errors()], 402);
        }

        if ($data['password'] !== $data['confirm_password']) {
            $errors['password'][] = 'A senha e a confirmação precisam ser iguais';
            $errors['confirm_password'][] = 'A senha e a confirmação precisam ser iguais';
            return response()->json((object) ["errors" => $errors], 400);
        }

        if(!$data['email'] || !$data['token']){
            return response()->json(['message' => 'Operação não autorizada'], 403);
        }
 
        DB::beginTransaction();
        try {
            $tokenData = DB::table('password_resets')->where('token', $data['token'])->first();
            if (!$tokenData) return response()->json(['message' => 'Operação não autorizada'], 403);

            $user = Client::where('email', $tokenData->email)->first();
            if (!$user) return response()->json(['message' => 'Operação não autorizada'], 403);
            $user->password =  bcrypt($data['password']);
            $user->update();

            DB::table('password_resets')->where('email', $user->email)->delete();
            Mail::to($user->email)->send(new RecoverEmailSuccessClient($user));

            DB::commit();
            return response()->json(['message' => 'Sua senha foi atualizada com sucesso'], 200);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Erro na operação, tente novamente']);
        }
    }

    private function getClientId()
    {
        return auth()->check() ? auth()->user()->id : '';
    }
}

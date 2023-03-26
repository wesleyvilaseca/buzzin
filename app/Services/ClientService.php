<?php

namespace App\Services;

use App\Http\Resources\ClientResource;
use App\Models\Client;
use App\Repositories\Contracts\ClientRepositoryInterface;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Repositories\Contracts\TenantRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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

        $data['mobile_phone'] = $mobilePhoneIsValid;
        $client = $this->clientRepository->createNewClient($data);
        return new ClientResource($client);
    }

    public function updatePasswordAccount(array $data) {
        $validate = Validator::make($data, [
            'new_password' => ['required', 'min:8'],
            'new_password_confirm' => ['required', 'min:8'],
        ]);

        if ($validate->fails()) {
            return response()->json((object) ["errors" => $validate->errors()], 400);
        }

        if($data['new_password'] !== $data['new_password_confirm']) {
            return response()->json((object)[
                'errors' => (object)[
                    'new_password' => ['A senha e confirmação da senha precisam ser iguais'],
                    'new_password_confirm' => ['A senha e confirmação da senha precisam ser iguais']
                ]
            ], 422);
        }

        $client_id = $this->getClientId();
        $res = Client::where('id', $client_id)->update(['password' => bcrypt($data['new_password'])]);

        if(!$res) {
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
        if(sizeof($validateCpf) > 0) {
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
        if(!$res) {
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

    private function getClientId()
    {
        return auth()->check() ? auth()->user()->id : '';
    }
}

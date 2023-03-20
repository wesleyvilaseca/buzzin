<?php

namespace App\Services;

use App\Http\Resources\ClientResource;
use App\Models\Client;
use App\Repositories\Contracts\ClientRepositoryInterface;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Repositories\Contracts\TenantRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Auth;

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

    public function update(int $id, array $data)
    {
        
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
            if($exist) {
                $errors['cpf'][] = 'Já existe um cadastro com esta credencial';
            }
        }

        if(!validaCPF($cpf)){
            $errors['cpf'][] = 'O CPF informado é inválido';
        }

        return $errors;
    }
}

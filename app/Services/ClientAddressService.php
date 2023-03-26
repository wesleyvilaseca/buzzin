<?php

namespace App\Services;

use App\Http\Resources\ClientAddressResource;
use App\Http\Resources\ClientResource;
use App\Models\Client;
use App\Repositories\Contracts\ClientAddressRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class ClientAddressService
{
    protected $clientRepository;
    private $clientService;

    public function __construct(ClientAddressRepositoryInterface $clientRepository, ClientService $clientService)
    {
        $this->clientRepository = $clientRepository;
        $this->clientService = $clientService;
    }

    public function getClientAddressById(int $id, int $client_id)
    {
        return $this->clientRepository->getClientAddressById($id, $client_id);
    }

    public function getClientAddress(int $client_id)
    {
        $address = $this->clientRepository->getClientAddress($client_id);
        return ClientAddressResource::collection($address);
    }

    public function createNewAddress(array $data)
    {
        //significa que o cliente está castrando o cpf pela primeira vez
        if (isset($data['cpf']) && $data['cpf'] !== "") {
            $client_id = Auth::user()->id;
            $res = $this->clientService->validateCpf($data["cpf"], $client_id);
            if (sizeof($res) > 0) {
                return response()->json((object) ["errors" => $res], 400);
            }

            Client::where('id', $client_id)->update(['cpf' => unMaskCPF($data['cpf'])]);
        }

        $res = $this->clientRepository->createNewAddress($data);
        if (!$res) {
            return response()->json(['message' => 'Erro na operação, tente novamente'], 400);
        }

        return new ClientAddressResource($res);
    }

    public function updateAddress(array $data, int $id)
    {
        $exist = $this->getClientAddressById($id, $this->getClientId());
        if (!$exist) {
            return response()->json(['message' => 'Operação não autorizada'], 401);
        }

        $res = $this->clientRepository->updateAddress($data, $id);
        if (!$res) {
            return response()->json(['message' => 'Erro na operação'], 403);
        }

        return response()->json(['message' => 'Endereço atualizado com sucesso'], 200);
    }

    public function deleteAddress(int $id)
    {
        $client_id = $this->getClientId();
        $address = $this->getClientAddressById($id, $client_id);
        if (!$address) {
            return response()->json(['message' => "Operação não autorizada", 401]);
        }

        $res = $address->delete();
        if(!$res) {
            return response()->json(['message' => 'Erro na operação'], 403);
        }

        return response()->json(['message' => 'Endereço removido com sucesso'], 200);
    }

    private function getClientId()
    {
        return auth()->check() ? auth()->user()->id : '';
    }
}

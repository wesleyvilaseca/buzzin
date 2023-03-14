<?php

namespace App\Services;

use App\Http\Resources\ClientAddressResource;
use App\Http\Resources\ClientResource;
use App\Repositories\Contracts\ClientAddressRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class ClientAddressService
{
    protected $clientRepository;

    public function __construct(ClientAddressRepositoryInterface $clientRepository)
    {
        $this->clientRepository = $clientRepository;
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
        $res = $this->clientRepository->createNewAddress($data);
        if (!$res) {
            return response()->json(['message' => 'Erro na operação, tente novamente'], 400);
        }

        return new ClientAddressResource($res);
    }

    public function updateAddress(array $data, int $id, int $client_id = null)
    {
        $exist = $this->getClientAddressById($id, $client_id ? $client_id : Auth::user()->id);
        if (!$exist) {
            return response()->json(['message' => 'Operação não autorizada'], 401);
        }

        $res = $this->clientRepository->updateAddress($data, $id);
        if (!$res) {
            return response()->json(['message' => 'Erro na operação'], 403);
        }

        return response()->json(['message' => 'Endereço atualizado com sucesso'], 200);
    }
}

<?php

namespace App\Services;

use App\Http\Resources\ClientResource;
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
}

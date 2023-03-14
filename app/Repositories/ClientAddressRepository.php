<?php

namespace App\Repositories;

use App\Models\Client;
use App\Models\ClientAddress;
use App\Repositories\Contracts\ClientAddressRepositoryInterface;
use Illuminate\Support\Facades\DB;

class ClientAddressRepository implements ClientAddressRepositoryInterface
{

    protected $entity;

    public function __construct(ClientAddress $client)
    {
        $this->entity = $client;
    }

    public function getClientAddressById(int $id, int $client_id)
    {
        return $this->entity->where(['id' => $id, 'client_id' => $client_id])->first();
    }

    public function getClientAddress(int $client_id)
    {
        return $this->entity->where('client_id', $client_id)->get();
    }

    public function createNewAddress(array $data)
    {
        return $this->entity->create($data);
    }

    public function updateAddress(array $data, int $id)
    {
        return $this->entity->where('id', $id)->update($data);
    }
}

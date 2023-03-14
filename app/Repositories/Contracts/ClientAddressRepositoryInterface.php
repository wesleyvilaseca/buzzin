<?php

namespace App\Repositories\Contracts;

interface ClientAddressRepositoryInterface
{
    public function getClientAddressById(int $id, int $client_id);
    public function getClientAddress(int $client_id);
    public function createNewAddress(array $data);
    public function updateAddress(array $data, int $id);
}

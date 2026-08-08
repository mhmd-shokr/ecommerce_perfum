<?php

namespace App\Servicies;

use App\Repositries\AddressRepository;

class AddressService
{
    public function __construct(
        protected AddressRepository $addressRepository
    ) {}

    public function getUserAddresses(int $userId)
    {
        return $this->addressRepository->getUserAddresses($userId);
    }

    public function createAddress(int $userId, array $data)
    {
        return $this->addressRepository->createAddress(
            $userId,
            $data
        );
    }

    public function getAddress(int $userId, int $addressId)
    {
        $address = $this->addressRepository->getById($addressId);

        if (!$address || $address->user_id !== $userId) {
            throw new \Exception(__('Address not found.'));
        }

        return $address;
    }

    public function updateAddress(int $userId,int $addressId,array $data) {
        $address = $this->getAddress($userId, $addressId);

        return $this->addressRepository->updateAddress(
            $address->id,
            $data
        );
    }

    public function deleteAddress(int $userId,int $addressId) {
        $address = $this->getAddress($userId, $addressId);

        return $this->addressRepository->deleteAddress(
            $addressId
        );
    }
}
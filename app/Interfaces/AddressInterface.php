<?php
namespace App\Interfaces;
Interface AddressInterface{
    public function getUserAddresses(int $userId);

    public function createAddress(int $userId, array $data);
    
    public function getById(int $addressId);
    
    public function updateAddress(int $addressId, array $data);
    
    public function deleteAddress(int $addressId): bool;
}
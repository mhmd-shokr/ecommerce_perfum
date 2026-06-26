<?php
namespace App\Interfaces;
Interface AddressInterface{
    public function getUserAddress(int $userId);

    public function createAddress(int $userId,array $data);

    public function getById(int $addressId);
}
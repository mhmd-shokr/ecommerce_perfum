<?php 
namespace App\Repositries;
use App\Interfaces\AddressInterface;
use App\Models\Address;
class AddressRepository implements AddressInterface{
    public function getUserAddresses(int $userId)
    {
        return Address::where('user_id', $userId)
            ->latest()
            ->get();
    }

    public function createAddress(int $userId, array $data)
    {
        return Address::create(
            array_merge(
                ['user_id' => $userId],
                $data
            )
        );
    }

    public function getById(int $addressId)
    {
        return Address::find($addressId);
    }

    public function updateAddress(int $addressId, array $data)
    {
        $address = Address::findOrFail($addressId);

        $address->update($data);

        return $address->fresh();
    }

    public function deleteAddress(int $addressId): bool
    {
        return (bool) Address::findOrFail($addressId)->delete();
    }
}
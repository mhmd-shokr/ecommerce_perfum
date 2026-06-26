<?php 
namespace App\Repositries;
use App\Interfaces\AddressInterface;
use App\Models\Address;
class AddressRepository implements AddressInterface{
    public function getUserAddress(int $userId){
        return  Address::where('user_id',$userId)->latest()->get();
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

    public function getById(int $addressId){
        return  Address::find($addressId);
    }
}
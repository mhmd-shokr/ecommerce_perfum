<?php
namespace App\Repositries;

use App\Interfaces\UserInterface;
use App\Models\User;

class UserRepository implements UserInterface{
    public function count()
    {
        return User::whereHas('roles',function($q){
            $q->where('name','customer');
        })->count();
    }

    public function create(array $data){
        return User::create($data);
    }
}
<?php
namespace App\Repositries;

use App\Interfaces\UserInterface;
use App\Models\User;

class UserRepository implements UserInterface{
    public function findByEmail(string $email){
        return User::where('email',$email)->first();
    }
    public function findByResetToken(string $token){
        return User::where('password_reset_token', $token)->first();
    }
    public function count()
    {
        return User::whereHas('roles',function($q){
            $q->where('name','customer');
        })->count();
    }
    public function create(array $data){
        return User::create($data);
    }
    public function update(User $user ,array $data):User{
        $user->update($data);
        return $user->refresh();
    }
    
    public function delete(user $user){
        $user->delete();
    }

    public function getDevices(User $user)
    {
        return $user->tokens()->select('id','name','last_used_at','created_at')
        ->orderByDesc('created_at')->get();
    }

    public function removeDevice(User $user,int $tokenId){
        return $user->tokens()->where('id',$tokenId)
        ->delete();
    }
}
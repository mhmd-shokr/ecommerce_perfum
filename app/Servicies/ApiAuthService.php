<?php
namespace App\Servicies;

use App\Repositries\UserRepository;
use Illuminate\Validation\ValidationException;

use Illuminate\Support\Facades\Auth;

class  ApiAuthService{
    public function __construct(protected UserRepository $userRepository)
    {
    }

    public function register(array $data){
        $user=$this->userRepository->create($data);
        $token=$user->createToken('api')->plainTextToken;

        return[
            'user'=>$user,
            'token'=>$token,
        ];
    }

    public function login(array $data){
        if(!Auth::attempt([
            'email'=>$data['email'],
            'password'=>$data['password'],
        ])){
            throw  ValidationException::withMessages([
                'email'=>[__('Invalid credentials')],
            ]);
        }

        $user=Auth::user();
        $token = $user->createToken($data['device_name']??'api')->plainTextToken;
        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    public function logout($user){
        $user->currentAccessToken()->delete();
    }
    public function logoutAll($user){
        $user->tokens()->delete();
    }
}
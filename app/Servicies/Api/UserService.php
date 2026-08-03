<?php
namespace App\Servicies\Api;

use App\Interfaces\UserInterface;
use App\Jobs\SendOtpVerificationEmail;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserService{
    public function __construct(protected UserInterface $userRepo){}

    public function update(User $user,array $data){
        $emailChanged=isset($data['email']) && $data['email'] !==$user->email;
        if($emailChanged){
            $data['email_verified_at'] = null;
        }
        $user=$this->userRepo->update($user,$data);
        if($emailChanged){
            $otp=$user->generateOtp();
                SendOtpVerificationEmail::dispatch($user,$otp);
        }
        return $user;   
    }
    public function updatePassword(User $user,string $currentPassword,string $newPassword){
        if(!Hash::check($currentPassword,$user->password)){
            throw ValidationException::withMessages([
                'current_password'=>[__('Current password is incorrect'),]
            ]);
        }
        $user->update([
            'password'=>$newPassword,
        ]);

        $currentAccessTokenId=$user->currentAccessToken()->id;
        $user->tokens()->where('id','!=',$currentAccessTokenId)->delete();
    }

    public function deleteAccount(User $user,string $currPassword){
        if(!Hash::check($currPassword,$user->password)){
            throw ValidationException::withMessages([
                'password'=> __('Current password is incorrect.')
            ],);
        }
        $user->tokens()->delete();
        $this->userRepo->delete($user);
    }

    public function getDevices(User $user){
        return $this->userRepo->getDevices($user);
    }

    public function removeDevice(User $user,int $tokenId){
        $this->userRepo->removeDevice($user, $tokenId);
    }
}
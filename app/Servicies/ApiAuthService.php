<?php
namespace App\Servicies;

use App\Interfaces\UserInterface;
use App\Jobs\SendOtpVerificationEmail;
use App\Jobs\SendPasswordResetOtpEmail;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class  ApiAuthService{
    public function __construct(protected UserInterface $userRepository)
    {
    }

    public function register(array $data){
        $user=$this->userRepository->create($data);
        $user->assignRole('Customer');
        $token=$user->createToken('api')->plainTextToken;
        $otp=$user->generateOtp();
        SendOtpVerificationEmail::dispatch($user,$otp);
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

    public function verifyEmail($user,string $otp){
        if(!$user->verifyOtp($otp)){
            throw ValidationException::withMessages([
                'otp'=>[__('Invalid or expired otp')],
            ]);
        }
        if(!$user->hasVerifiedEmail()){
            $user->markEmailAsVerified();
        }
        $user->clearOtp();
    }

    public function resendOtp($user){
        if($user->hasVerifiedEmail()){
            throw ValidationException::withMessages([
                'email'=>[__('Email is already verified')],
            ]);
        }
        $otp =$user->generateOtp();
        SendOtpVerificationEmail::dispatch($user, $otp);
    }

    public function forgotPassword(string $email){
        $user=$this->userRepository->findByEmail($email);
        if(!$user) return;
        $otp=$user->generatePasswordResetOtp();
        SendPasswordResetOtpEmail::dispatch($user, $otp);
    }

    public function verifyResetOtp(string $email,string $otp){
        $user=$this->userRepository->findByEmail($email);
        if(!$user || !$user->verifyPasswordResetOtp($otp)){
            throw ValidationException::withMessages([
                'otp' => [__('Invalid or expired OTP.')],
            ]);
        }
        $user->clearPasswordResetOtp();
        return $user->generatePasswordResetToken();
        
    }

    public function resetPassword(string $token,string $password){
        $user=$this->userRepository->findByResetToken($token);
        if(!$user||!$user->password_reset_token_expires_at || now()->gt($user->password_reset_token_expires_at )){
            throw ValidationException::withMessages([
                'reset_token'=>[__('Invalid or expired reset token')],
            ]);
        }
        $user->update([
            'password'=>$password,
            'password_reset_token'=>null,
            'password_reset_token_expires_at'=>null,
        ]);

        $user->tokens()->delete();
    }
}
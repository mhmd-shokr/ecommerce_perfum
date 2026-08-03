<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\ForgotPasswordRequest;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Http\Requests\Api\Auth\ResetPasswordRequest;
use App\Http\Requests\Api\Auth\VerifyOtpRequest;
use App\Http\Requests\Api\Auth\VerifyResetOtpRequest;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use App\Jobs\SendWelcomeEmail;
use App\Servicies\ApiAuthService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use ApiResponse;

    public function __construct(protected ApiAuthService $apiAuthService)
    {
    }

    public function register(RegisterRequest $request){
        $validated=$request->validated();
        $registered=$this->apiAuthService->register($validated);
        

        return $this->successResponse(
            [
                'user'=>new UserResource($registered['user']),
                'token'=>$registered['token']
            ],
            'Registered successfully',
            201,
        );
    }

    public function login(LoginRequest $request){
        $validated=$request->validated();
        $login=$this->apiAuthService->login($validated);
        return $this->successResponse(
            [
                'user'=>new UserResource($login['user']),
                'token'=>$login['token']
            ],
            'Login successfully',
        );
    }

    public function user(Request $request){
        return $this->successResponse(
                new UserResource($request->user()),
                'User retrieved successfully'
            );
    }

    public function logout(Request $request){
        $this->apiAuthService->logout($request->user());
        return $this->successResponse(
            null,
            'Logged out successfully.'
        );
    }
    public function logoutAll(Request $request){
        $this->apiAuthService->logoutAll($request->user());
        return $this->successResponse(
            null,
            'Logged out from all devices.'
        );
    }

    public function verifyEmail(VerifyOtpRequest $request){
        $validated=$request->validated();
        $user=$request->user();
        $this->apiAuthService->verifyEmail($user,$validated['otp']);
        SendWelcomeEmail::dispatch($user);
        return $this->successResponse(
            null,
            'Email verified successfully.'
        );
    }

    public function resendOtp(Request $request){
        $user=$request->user();
        $this->apiAuthService->resendOtp($user);
        return $this->successResponse(
            null,
            'OTP resent successfully'
        );
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $validated=$request->validated('email');
        $this->apiAuthService->forgotPassword($validated);
        return $this->successResponse(
            null,
            'If the email exists, a password reset code has been sent.'
        );
    }

    public function verifyResetOtp(VerifyResetOtpRequest $request){
        $token = $this->apiAuthService->verifyResetOtp(
            $request->validated('email'),
            $request->validated('otp')
        );
    
        return $this->successResponse(
            [
                'reset_token' => $token,
            ],
            'OTP verified successfully.'
        );
    }
    public function resetPassword(ResetPasswordRequest $request){
        $this->apiAuthService->resetPassword($request->validated('reset_token'),$request->validated('password'));

        return $this->successResponse(
            null,
            'Password reset successfully. Please login again.'
        );
    }
}

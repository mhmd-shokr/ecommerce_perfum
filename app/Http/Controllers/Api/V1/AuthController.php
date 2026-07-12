<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\UserResource;
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
}

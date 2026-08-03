<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\ChangePasswordRequest;
use App\Http\Requests\Api\User\DeleteAccountRequest;
use App\Http\Requests\Api\User\UpdateProfileRequest;
use App\Http\Resources\DeviceResource;
use App\Http\Resources\UserResource;
use App\Servicies\Api\UserService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use ApiResponse ;
    public function __construct(
        protected UserService $userService
    ) {
    }

    public function update(UpdateProfileRequest $request){
        $user=$this->userService->update($request->user(),$request->validated());
        return $this->successResponse(
            new UserResource($user),
            'Profile updated successfully.'
        );
    }

    public function changePassword(ChangePasswordRequest $request){
        $user=$request->user();
        $validatedPass=$request->validated('password');
        $validatedCurrPass=$request->validated('current_password');
        $this->userService->updatePassword($user,$validatedCurrPass,$validatedPass);
        return $this->successResponse(
            null,
            'Password changed successfully'
        );
    }

    public function deleteAccount(DeleteAccountRequest $request){
        $this->userService->deleteAccount($request->user(),$request->validated('current_password'));
        return $this->successResponse(
            null,
            'Account deleted successfully.'
        );
    }

    public function getDevices(Request $request){
        $devices=$this->userService->getDevices($request->user());
        return $this->successResponse(
            DeviceResource::collection($devices),
            'Devices retrieved successfully'   
        );
    }

    public function removeDevice(request $request,$token){
        $this->userService->removeDevice($request->user(),$token);
        return $this->successResponse(
            null,
            'Device removed successfully'
        );
    }
}

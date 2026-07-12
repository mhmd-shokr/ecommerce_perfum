<?php

namespace App\Traits;
use Illuminate\Http\Illuminate\Http\JsonResponse;
use Illuminate\Http\JsonResponse as HttpJsonResponse;
use Symfony\Component\HttpFoundation\JsonResponse as HttpFoundationJsonResponse;

Trait ApiResponse {
public function successResponse(Mixed $data=null,string $message,int $status=200):HttpJsonResponse{
        return response()->json([
            'success'=>true,
            'message'=>__($message),
            'data'=>$data,
        ],$status);
    }


    public function errorResponse(string $message='Something went wrong',Mixed $errors=null,int $status=400):HttpFoundationJsonResponse{
        return response()->json([
            'success'=>false,
            'message'=>__($message),
            'errors'=>$errors,
        ],$status);
    }
}
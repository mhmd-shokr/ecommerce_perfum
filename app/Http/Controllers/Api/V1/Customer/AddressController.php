<?php

namespace App\Http\Controllers\Api\V1\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAddressRequest;
use App\Http\Requests\UpdateAddressRequest;
use App\Http\Resources\AddressResource;
use App\Servicies\AddressService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    use ApiResponse;
    public function __construct(
        protected AddressService $addressService
    ) {}

    public function index()
    {
        $addresses = $this->addressService
            ->getUserAddresses(Auth::id());

        return $this->successResponse(
            AddressResource::collection($addresses),
            'Address deleted successfully',
        );
    }

    public function store(StoreAddressRequest $request)
    {
        $address = $this->addressService->createAddress(
            Auth::id(),
            $request->validated()
        );

        return $this->successResponse(
            new AddressResource($address),
            __('Address created successfully'),
            201
        );
    }

    public function show(int $address)
    {
        $address = $this->addressService->getAddress(
            Auth::id(),
            $address
        );

        return $this->successResponse(
            new AddressResource($address),
            __('Address retrieved successfully'),
            200
        );
    }

    public function update(
        UpdateAddressRequest $request,
        int $address
    ) {
        $address = $this->addressService->updateAddress(
            Auth::id(),
            $address,
            $request->validated()
        );

        return $this->successResponse(
            new AddressResource($address),
            __('Address updated successfully'),
            200
        );
    }

    public function destroy(int $address)
    {
        $this->addressService->deleteAddress(
            Auth::id(),
            $address
        );
        return $this->successResponse(
            new AddressResource($address),
            __('Address deleted successfully'),
            200
        );
    }
}

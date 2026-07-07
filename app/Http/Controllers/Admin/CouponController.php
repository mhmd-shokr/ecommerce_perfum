<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CouponRequest;
use App\Servicies\CheckoutService;
use App\Servicies\CouponService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CouponController extends Controller
{
    public function __construct(protected CouponService $couponService ,protected  CheckoutService $checkoutService)
    {
    }

    public function index(){
        $coupons = $this->couponService->getAll();
        return view('admin.coupons.index', compact('coupons'));
    }
    
    public function create()
    {
        return view('admin.coupons.create');
    }

    public function store(Request $request){
        $validated=$request->validated();
        $validated['is_active']=$request->boolean('is_active',true);

        $this->couponService->create($validated);
        return redirect()
            ->route('admin.coupons.index')
            ->with('success', __('Coupon created successfully'));
    }

    public function edit(int $id)
    {
        $coupon = $this->couponService->findById($id);
        return view('admin.coupons.edit', compact('coupon'));
    }
    public function update(CouponRequest $request, int $id){
        $validated=$request->validated();
        $validated['is_active']=$request->boolean('is_active',true);
        $this->couponService->update($id, $validated);

        return redirect()
            ->route('admin.coupons.index')
            ->with('success', __('Coupon updated successfully'));
    }
    public function destroy(int $id)
    {
        $this->couponService->delete($id);

        return redirect()
            ->route('admin.coupons.index')
            ->with('success', __('Coupon deleted successfully'));
    }public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string',
        ]);
    
        try {
            $coupon = $this->couponService->validate($request->coupon_code);
            $checkoutData = $this->checkoutService->getCheckoutData(Auth::id());
            $subtotal = $checkoutData['subtotal'];
            $discount = $this->couponService->applyDiscount($coupon, $subtotal);
    
            return response()->json([
                'valid'    => true,
                'discount' => round($discount, 2),
                'message'  => __('Coupon applied successfully'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'valid'   => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }
}

<?php
namespace App\Servicies;

use App\Repositries\AddressRepository;
use App\Repositries\CheckoutRepository;
use App\Repositries\CouponRepository;
use App\Repositries\ShippingZoneRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutService{

    public function __construct(
        protected CheckoutRepository $checkoutRepo,
        protected AddressRepository $addressRepo,
        protected ShippingZoneRepository $shippingZoneRepo,
        protected CouponService $couponService,
        protected CouponRepository $couponRepository
    ){}

    public function getCheckoutData(int $userId){
        $cartItems = $this->checkoutRepo->getCart($userId);
        if($cartItems->isEmpty()){
            throw new \Exception(__('Your cart is empty'));
        }
        $subTotal = $cartItems->sum(function ($item) {
            return $item->quantity * ($item->product->sale_price ?? $item->product->price);
        });

        return [
            'cartItems'     => $cartItems,
            'addresses'     => $this->addressRepo->getUserAddress($userId),
            'shippingZones' => $this->shippingZoneRepo->getAll(),
            'subtotal'      => $subTotal,
        ];
    }

    public function placeOrder(int $userId, array $data){
        $cartItems = $this->checkoutRepo->getCart($userId);

        if($cartItems->isEmpty()){
            throw new \Exception(__('Your cart is empty'));
        }

        foreach($cartItems as $item){
            if($item->quantity > $item->product->stock_quantity){
                throw new \Exception(
                    __(':product does not have enough stock',[
                        'product' => $item->product->getTranslation('name', app()->getLocale())
                    ])
                );
            }
        } 

        // calc subtotal
        $subtotal = $cartItems->sum(function($item){
            return $item->quantity * ($item->product->sale_price ?? $item->product->price);
        });

       
        return DB::transaction(function() use( $userId, $data, $cartItems, $subtotal){

         //apply coupon 
            $discount =0;
            $coupon=null;
            if(!empty($data['coupon_code'])){
                $coupon=$this->couponService->validate($data['coupon_code']);
                $discount=$this->couponService->applyDiscount($coupon,$subtotal);
            }

            //address
            if(!empty($data['address_id'])){
                $address = $this->addressRepo->getById($data['address_id']);
                if(!$address || $address->user_id !== $userId){
                    throw new \Exception(__('Invalid address'));
                }
                // fetch governorate from DB
                $shippingCost = $this->shippingZoneRepo->getCostByGovernorate($address->governorate)??0;
            }else{
                $address = $this->addressRepo->createAddress($userId,[
                    'full_name'   => $data['full_name'],
                    'phone'       => $data['phone'],
                    'governorate' => $data['governorate'],
                    'city'        => $data['city'],
                    'street'      => $data['street'],
                    'building'    => $data['building'] ?? null,
                    'floor'       => $data['floor']    ?? null,
                    'notes'       => $data['notes']    ?? null,
                ]);
                // fetch governorate from data
                $shippingCost = $this->shippingZoneRepo->getCostByGovernorate($data['governorate']) ?? 0;
            }

            // calc total
            $total = max(0, $subtotal + $shippingCost - $discount);

            // create order
            $order = $this->checkoutRepo->createOrder([
                'user_id'        => $userId,
                'address_id'     => $address->id,
                'order_number' => 'ORD_' . strtoupper(Str::random(10)),
                'sub_total'      => $subtotal,
                'shipping_cost'  => $shippingCost,
                'discount'       => $discount,
                'total'          => $total,
                'status'         => 'pending',
                'payment_method' => $data['payment_method'],
                'payment_status' => 'pending',
                'payment_reference' => null,
                
            ]);
                if($coupon){
                $this->couponRepository->incrementUsage($coupon->id);
                }

            // create items
            $this->checkoutRepo->createOrderItems($order, $cartItems);

            return $order;
        });
    }

    public function getShippingCost(string $governorate){
        return $this->shippingZoneRepo->getCostByGovernorate($governorate);
    }
}
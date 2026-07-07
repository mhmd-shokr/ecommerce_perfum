<?php
namespace App\Servicies;

use App\Repositries\CouponRepository;
use Illuminate\Support\Collection;

class CouponService{
    public function __construct(protected CouponRepository $couponRepository){}

    public function validate(string $code){
        $coupon=$this->couponRepository->findByCode($code);
        if(!$coupon){
            throw new \Exception('Invalid coupon');
        }

        if(!$coupon->is_active){
            throw new \Exception('Coupon inactive');
        }

        if($coupon->expires_at && now()->gt($coupon->expires_at)){
            throw new \Exception('Coupon expired');
        }

        if($coupon->usage_limit && $coupon->used_count >= $coupon->usage_limit){
            throw new \Exception('Coupon used up');
        }

        return $coupon;
    }

   
    public function applyDiscount($coupon,$subtotal){
        if($coupon->type=='fixed'){
            return min($coupon->value,$subtotal);
        }
        $percentage = min($coupon->value, 100);
        return ($subtotal * $percentage) /100;
    }

    public function getAll(){
        return $this->couponRepository->getAll();
    }

    public function findById(int $id)
    {
        return $this->couponRepository->findById($id);
    }

    public function create(array $data)
    {
        return $this->couponRepository->create($data);
    }

    public function update(int $id, array $data)
    {
        return $this->couponRepository->update($id, $data);
    }

    public function delete(int $id)
    {
        return $this->couponRepository->delete($id);
    }
}
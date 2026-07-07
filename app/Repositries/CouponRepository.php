<?php
namespace App\Repositries;

use App\Interfaces\CouponInterface;
use App\Models\Coupon;
use Override;

class CouponRepository implements CouponInterface{

    public function getAll(){
        return Coupon::latest()->paginate(8);
    }    

    public function findById(int $id)
    {
        return Coupon::findOrFail($id);
    }
    public function findByCode(string $code)
    {
        return Coupon::where('code',$code)->first();
    }

    public function create(array $data)
    {
        return Coupon::create($data);
    }

    public function update(int $id, array $data)
    {
        $coupon = $this->findById($id);
        $coupon->update($data);
        return $coupon;
    }

    public function delete(int $id)
    {
        return Coupon::destroy($id);
    }
    
    public function incrementUsage(int $id)
    {
        return Coupon::where('id',$id)->increment('used_count');
        
    }
}
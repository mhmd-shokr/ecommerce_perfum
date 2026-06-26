<?php 

namespace App\Repositries;

use App\Interfaces\ShippingZoneInterface;
use App\Models\ShippingZone;

class ShippingZoneRepository implements ShippingZoneInterface{
    public function getAll(){
        return ShippingZone::orderBy('governorate')->get();
    }
    public function getCostByGovernorate(string $governorate){
        $zone=ShippingZone::where('governorate',$governorate)->first();
        return $zone ?(float)$zone->cost :'0.0';
    }
}
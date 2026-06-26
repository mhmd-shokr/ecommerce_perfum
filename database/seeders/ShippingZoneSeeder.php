<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ShippingZone;

class ShippingZoneSeeder extends Seeder
{
    public function run(): void
    {
        $zones = [
            ['governorate' => 'Cairo', 'cost' => 50],
            ['governorate' => 'Giza', 'cost' => 45],
            ['governorate' => 'Alexandria', 'cost' => 60],
            ['governorate' => 'Gharbia', 'cost' => 40],
            ['governorate' => 'Dakahlia', 'cost' => 45],
        ];

        foreach ($zones as $zone) {
            ShippingZone::updateOrCreate(
                ['governorate' => $zone['governorate']],
                ['cost' => $zone['cost']]
            );
        }
    }
}
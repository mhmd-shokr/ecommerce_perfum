<?php
namespace   App\Interfaces;

Interface ShippingZoneInterface{
    public function getAll();
    public function getCostByGovernorate(string $governorate);
}
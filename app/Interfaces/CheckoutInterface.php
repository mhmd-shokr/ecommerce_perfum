<?php
namespace App\Interfaces;

use App\Models\Order;
use Illuminate\Support\Collection;



Interface CheckoutInterface{
    public function getCart(int $userId);

    public function createOrder(array $data);
    public function createOrderItems(Order $order,Collection $cartItems):void;

    public function decrementStock(Collection $cartItems);
    public function clearCart(int $userId);
}
<?php
namespace App\Repositries;

use App\Interfaces\CheckoutInterface;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Servicies\StockService;
use Illuminate\Support\Collection;
use Override;

class CheckoutRepository implements CheckoutInterface{
    public function __construct(protected StockService $stock_service){}
    public function getCart(int $userId){
        return Cart::where('user_id',$userId)->with('product')->get();
    }

    public function createOrder(array $data){
        return Order::create($data);
    }

    public function createOrderItems(Order $order,Collection $cartItems):void{
        $cartItems->each(function($item) use($order){
            $price=$item->product->sale_price ?? $item->product->price;
            $order->items()->create([
                'product_id'   => $item->product_id,
                'product_name' => $item->product->getTranslation('name', app()->getLocale()),
                'unit_price'   => $price,
                'quantity'     => $item->quantity,
                'total'        => $price * $item->quantity,
            ]);
        });
    }

    public function decrementStock(Collection $cartItems)
    {
        $cartItems->each(function ($item){
            $this->stock_service->decrease(
                $item->product,
                $item->quantity,
                'order placed'
            );
        });
    }

    // public function applyCoupon(Request $request){

    // }


    public function clearCart(int $userId)
    {
        return Cart::where('user_id',$userId)->delete();
    }
}
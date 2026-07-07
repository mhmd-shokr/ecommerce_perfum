<?php
namespace App\Servicies;

use App\Models\Product;
use App\Models\Stock_movement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StockService{
    public function increase(Product $product ,int $quantity,string $note=null){
        return $this->move($product,'increase',$quantity,$note);
    }

    public function decrease(Product $product ,int $quantity,string $note=null){
        return $this->move($product,'decrease',$quantity,$note);
    }


    public function move(Product $product,string $type,int $quantity,?string $note){
        return DB::transaction(function()use($product,$type,$quantity,$note){
            $locked = Product::where('id', $product->id)->lockForUpdate()->first();
            if(!$locked){
                throw new \Exception(__('Product not found'));
            }
            if($type == 'decrease' && $locked->stock_quantity < $quantity){
                throw new \Exception(__(':product does not have enough stock', ['product' => $locked->name]));
            }
            //Create movement
            Stock_movement::create
            ([
            'product_id' => $product->id, 
            'user_id' => Auth::id(), 
            'type' => $type, 
            'quantity' => $quantity,
            'notes' => $note, 
            ]);
            //Update product stock
            if($type=='increase'){
                $product->stock_quantity+=$quantity;
            }else{
                $locked->stock_quantity -= $quantity;
            }
            //Update status
            $locked->is_out_of_stock = $locked->stock_quantity <= 0;
            $locked->save();
            return $locked;
        });
    }

    public function hasStock(Product $product,int $quantity){
        return $product->stock_quantity >= $quantity;
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable=[
        'user_id',
        'address_id',
        'order_number',
        'sub_total',
        'shipping_cost',
        'discount',
        'total',
        'status',
        'payment_status',
        
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function address()
    {
        return $this->belongsTo(Address::class);
    }
    
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}

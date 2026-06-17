<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock_movement extends Model
{
    protected $fillable=[
        'product_id',
        'user_id',
        'type',
        'quantity',
        'notes',
    ];
    public function product()
{
    return $this->belongsTo(Product::class);
}
}

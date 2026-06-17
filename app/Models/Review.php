<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable=[
        'product_id',
        'user_id',
        'rating',
        'title',
        'status',
        'comment',
        'is_verified',
        'is_approved'
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'status' => 'boolean',
    ];

    public function product(){
        return $this->belongTo(Product::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

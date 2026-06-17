<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FragranceNote extends Model
{
    protected $Fillable=[
        'name',
    'description',
    ];

    public function products()
{
    return $this->belongsToMany(Product::class);
}
}

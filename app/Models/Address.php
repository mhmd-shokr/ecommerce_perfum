<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'user_id',
        'full_name',
        'phone',
        'governorate',
        'city',
        'street',
        'building',
        'floor',
        'notes'
    ];

    public function user()
{
    return $this->belongsTo(User::class);
}
}

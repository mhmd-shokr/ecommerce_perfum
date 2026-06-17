<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class product_fragrance_note extends Model
{
    protected $fillable=[
        'product_id',
        'fragrance_note_id',
        'type',
    ];
}

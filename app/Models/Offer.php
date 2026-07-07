<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $fillable = [
        'coupon_id',
        'title',
        'description',
        'image',
        'button_text',
        'button_url',
        'status',
        'sent_at',
        'recipients_count',
        'expires_at'
    ];

    protected $casts = [
        'sent_at' => 'datetime',
        'expires_at'=>'datetime',
    ];


    public function isSent():Attribute{
        return Attribute::make(
            get:fn()=>$this->status === 'sent',
        );
    }

    protected function isExpired(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->expires_at?->isPast() ?? false,
        );
    }

    public function coupon()
{
    return $this->belongsTo(Coupon::class);
}
}
